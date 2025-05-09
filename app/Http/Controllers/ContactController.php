<?php

namespace App\Http\Controllers;

use App\Models\ContactType;
use App\Models\BlastAnswer;
use App\Models\ContactImportData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;


class ContactController extends Controller
{

    public function myContacts(Request $request)
    {

        $curr_userId = auth()->id();

        $contacts = ContactImportData::with('contactType')
            ->where('user_id', $curr_userId)
            ->where('status', 'active')
            ->get()
            ->makeHidden('contact_type_id'); // Yeh 'contact_type_id' ko response se hata dega

        $contactTypes = ContactType::where('user_id', $curr_userId)->get();

        return view('admin.pages.my-contacts', compact('contactTypes', 'contacts'));
    }

    public function updateContact($updId)
    {
        $curr_userId = auth()->id();
        $contacts = ContactImportData::with('contactType')
            ->where('user_id', $curr_userId)
            ->where('status', 'active')
            ->get()
            ->makeHidden('contact_type_id'); // Yeh 'contact_type_id' ko response se hata dega

        $contactTypes = ContactType::where('user_id', $curr_userId)->get();
        $updContact = ContactImportData::with('contactType')
            ->where('user_id', $curr_userId)
            ->where('id', $updId)
            ->first();

        return view('admin.pages.my-contacts', compact('contactTypes', 'contacts', 'updContact'));
    }

    public function deleteContact($delId)
    {
        $deleteStatus = ContactImportData::where('id', $delId)->delete();

        if ($deleteStatus) {
            return redirect()->route('my-contacts')->with('success', "Contact deleted successfully");
        } else {
            return redirect()->back()->withErrors(['error' => 'No matching record found or deletion failed']);
        }
    }

    // for CSV WITH AJAX
    public function storeMultipleContacts(Request $request): JsonResponse
    {
        $data = $request->input('data');
        Log::info('Raw data', ['data' => $data]);

        if (empty($data) || !is_array($data)) {
            return response()->json([
                'success' => false,
                'message' => 'No contact data received.',
            ], 422);
        }

        $curr_userId = auth()->id();
        $duplicateEmails = [];
        $duplicatePhones = [];
        $processedCount = 0;

        foreach ($data as $row) {
            // Skip rows without email or phone number
            $email = $row['c_email'] ?? null;
            $phone = $row['c_phno'] ?? null;

            if (empty($email) && empty($phone)) {
                continue;
            }

            $contact = [
                'contact_type_id' => 16,
                'c_fname' => $row['c_fname'] ?? '',
                'c_lname' => $row['c_lname'] ?? '',
                'c_email' => $email,
                'c_phno' => $phone,
                'c_city' => $row['c_city'] ?? null,
                'c_state' => $row['c_state'] ?? null,
                'c_timezone' => $row['c_timezone'] ?? null,
                'user_id' => $curr_userId
            ];

            // Validate contact
            $validator = Validator::make($contact, [
                'c_fname' => 'required|string',
                'c_lname' => 'nullable|string',
                'c_email' => 'nullable|email',
                'c_phno' => 'nullable|string',
                'user_id' => 'required|integer',
                'contact_type_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                continue;
            }

            // Check for duplicates
            $query = ContactImportData::where('user_id', $curr_userId);
            if (!empty($email)) {
                $query->where('c_email', $email);
            }
            if (!empty($phone)) {
                $query->orWhere('c_phno', $phone);
            }

            $existing = $query->first();

            if ($existing) {
                if (!empty($email)) {
                    $duplicateEmails[] = $email;
                }
                if (!empty($phone)) {
                    $duplicatePhones[] = $phone;
                }
                continue;
            }

            ContactImportData::create($contact);
            $processedCount++;
        }

        // If no rows were processed, return an error message
        if ($processedCount === 0) {
            return response()->json([
                'success' => false,
                'message' => 'No valid contacts were imported. They may be duplicates or missing required fields.',
                'duplicates' => array_unique(array_merge($duplicateEmails, $duplicatePhones))
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => "Contacts imported: $processedCount",
            'duplicates' => array_unique(array_merge($duplicateEmails, $duplicatePhones))
        ]);
    }





    //store and update single contact function
    public function storeOrUpdateContact(Request $request)
    {
        try {
            //code to chekc if the email exist for the current user not for all the user
            $validator = Validator::make($request->all(), [
                'c_email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('contact_import_data', 'c_email')
                        ->where(function ($query) {
                            $query->where('user_id', auth()->id());
                        })
                        ->ignore($request->updId),
                ],
                'c_fname'        => 'required|string|max:255',
                'c_lname'        => 'required|string|max:255',
                'c_phno'         => 'required|numeric|digits:10',
                'c_city'         => 'required|string|max:255',
                'c_state'        => 'required|string|max:255',
                'c_country'      => 'required|string|max:255',
                'c_contact_type' => 'required|numeric',
                'c_timezone'     => 'required|string',
            ], [
                'c_email.unique' => 'This email already exists for your contacts.',
                'c_phno.digits'  => 'The phone number must be exactly 10 digits.',
            ]);


            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $curr_userId = auth()->id();

            $data = [
                'c_fname' => $request->input('c_fname'),
                'c_lname' => $request->input('c_lname'),
                'c_email' => $request->input('c_email'),
                'c_phno' => $request->input('c_phno'),
                'c_city' => $request->input('c_city'),
                'c_state' => $request->input('c_state'),
                'c_country' => $request->input('c_country'),
                'user_id' => $curr_userId,
                'c_timezone' => $request->input('c_timezone'),
                'contact_type_id' => $request->input('c_contact_type'),
            ];

            $contactId = $request->input('updId');

            if ($contactId) {
                $contact = ContactImportData::find($contactId);
                if (!$contact) {
                    return redirect()->back()->withErrors(['error' => 'Contact not found'])->withInput();
                }
                $contact->update($data);
                $message = 'Contact updated successfully!';
            } else {
                ContactImportData::create($data);
                $message = 'Contact added successfully!';
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => 'Something went wrong: ' . $e->getMessage() . ' (Line: ' . $e->getLine() . ')'
            ])->withInput();
        }
    }

    public function storeContactType(Request $request)
    {
        try {
            if (!$request->update_id) {


                // Validation for the input data
                $validator = Validator::make($request->all(), [
                    'contact_type' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('contact_types', 'contact_type')
                            ->where('user_id', auth()->id()), // Ensuring uniqueness per logged-in user
                    ],
                ], [
                    'contact_type.unique' => 'This contact type already exists.',
                ]);

                // If validation fails, return back with errors
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }

            // Get the current authenticated user ID
            $curr_userId = auth()->id();

            // Check if status is present and set it to 'active' or 'inactive'
            $status = $request->has('status') ? 'active' : 'inactive';


            if ($request->update_id) {
                $newContactType = [
                    'contact_type' => $request->input('contact_type'),
                    'contact_desc' => $request->input('contact_desc'), // Corrected to use request input
                    'status' => $status,
                    'user_id' => $curr_userId,
                ];
                $updateContactType = ContactType::where('id', $request->update_id)->update($newContactType);

                // Check if the record is created and return appropriate response
                if ($updateContactType) {
                    return redirect('/contact-type')->with('success', 'Contact type updated successfully!');
                } else {
                    return redirect()->back()->withErrors('Failed to update Contact Type')->withInput();
                }
            } else {

                // Prepare the data for the new ContactType
                $newContactType = [
                    'contact_type' => $request->input('contact_type'),
                    'contact_desc' => $request->input('contact_desc'), // Corrected to use request input
                    'status' => $status,
                    'user_id' => $curr_userId,
                ];

                // Create the new ContactType record
                $addContactType = ContactType::create($newContactType);

                // Check if the record is created and return appropriate response
                if ($addContactType) {
                    return redirect()->back()->with('success', 'contact type added successfully!');
                } else {
                    return redirect()->back()->withErrors('Failed to add Contact Type')->withInput();
                }
            }
        } catch (\Exception $e) {
            // Handle exceptions and return a proper error message
            return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()])->withInput();
        }
    }

    public function getContactType()
    {
        $curr_userId = auth()->id();
        // Fetch only required columns (optional, depending on your needs)
        $contactTypes = ContactType::where('user_id', $curr_userId)->get();

        return view('admin.pages.contact-type', compact('contactTypes'));
    }

    public function deleteContactType(Request $request, $id)
    {
        try {

            // die();
            $curr_userId = auth()->id();

            // Find the contact type by its ID and user_id
            $contactType = ContactType::where('user_id', $curr_userId)
                ->where('id', $id)
                ->first();

            if (!$contactType) {
                return redirect()->back()->with('error', 'Contact type not found!');
            }

            // Check if this contact type is used in contact_import_data table
            $linkedCount = ContactImportData::where('contact_type_id', $contactType->id)
                ->count();


            if ($linkedCount > 0) {
                return redirect()->back()->withErrors(['contact_type' => 'This contact type is linked to other data and cannot be deleted.']);
            }

            // Safe to delete
            $contactType->delete();

            return redirect()->back()->with('success', 'Contact type deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    //pupulate contact type for updating in the form
    public function updatePopulateContactType(Request $request, $id)
    {
        $curr_userId = auth()->id();

        $updateContactType = ContactType::where('user_id', $curr_userId)
            ->where('id', $id)
            ->first();

        $contactTypes = ContactType::where('user_id', $curr_userId)->get();

        return view('admin.pages.contact-type', compact('updateContactType', 'contactTypes'));
    }

    //update data on tabele directly
    public function updateInline(Request $request)
    {

        //dump($request->all);
        $request->validate([
            'id' => 'required|exists:contact_import_data,id',
            'field' => 'required|string',
            'value' => 'nullable|string'
        ]);

        $contact = ContactImportData::find($request->id);

        $allowedFields = ['c_fname', 'c_lname', 'c_city', 'c_state', 'c_phno', 'c_email'];

        if (!in_array($request->field, $allowedFields)) {
            return response()->json(['success' => false], 403);
        }

        $contact->{$request->field} = $request->value;
        $contact->save();

        return response()->json(['success' => true]);
    }

    public function storeRepliesPageView()
    {
        return view('admin.pages.store-replies');
    }


    public function storeRepliesOfCustomers(Request $request)
    {
        $request->validate([
            'u_id' => 'required|number',
            'q_id' => 'required|number',
            'ans' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $addData = [
            'answer' => $request->ans,
            'question_id' => $request->q_id,
            'contact_id' => $request->u_id,
        ];

        $storeAnswertoDb = BlastAnswer::create($addData);


        return view('admin.pages.store-replies');
    }

    public function fetchContactAccordingContactType(Request $request)
    {

        $request->validate([
            'ctype' => 'required|array',
        ]);

        $data = $request->c_type_id;

        $contacts = ContactImportData::where('user_id', auth()->id())
            ->whereIn('contact_type_id', $data)
            ->get();

        return response()->json([
            'contacts' => $contacts,
        ]);
    }
}
