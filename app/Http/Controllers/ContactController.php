<?php

namespace App\Http\Controllers;

use App\Models\ContactType;
use App\Models\ContactImportData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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


        $deleteStatus = ContactImportData::where('id', $delId)
            ->delete();

        if ($deleteStatus) {
            return redirect()->back()->with('success', "Contact deleted successfully");
        } else {
            return redirect()->back()->withErrors(['error' => 'No matching record found or deletion failed']);
        }
    }

    // public function storeMultipleContacts(Request $request)
    // {
    //     try {
    //         Log::info('File upload initiated.');

    //         // Check if the file is uploaded
    //         if (!$request->hasFile('file')) {
    //             Log::error('No file uploaded.');
    //             return redirect()->back()->withErrors(['error' => 'No file uploaded.']);
    //         }

    //         $file = $request->file('file');

    //         // Validate file type
    //         if (!$file->isValid() || !in_array($file->getClientOriginalExtension(), ['csv', 'txt', 'xlsx'])) {
    //             Log::error('Invalid file uploaded.');
    //             return redirect()->back()->withErrors(['error' => 'Invalid file uploaded.']);
    //         }

    //         // Read and parse CSV data
    //         $csvData = file_get_contents($file->getPathname());
    //         $rows = array_map('str_getcsv', explode("\n", $csvData));

    //         if (empty($rows) || count($rows) < 2) {
    //             return redirect()->back()->withErrors(['error' => 'Empty or invalid CSV file.']);
    //         }

    //         // Extract and trim header
    //         $header = array_map(fn($value) => trim($value, "\xEF\xBB\xBF "), $rows[0]);   // Trim BOM and spaces
    //         $dataRows = array_slice($rows, 1);  // Skip header row


    //         // Start transaction
    //         DB::beginTransaction();

    //         $insertedCount = 0;
    //         $skippedCount = 0;

    //         foreach ($dataRows as $index => $row) {
    //             Log::info("Processing Row {$index}: ", $row);

    //             // Skip empty rows
    //             if (!empty(array_filter($row))) {
    //                 $row = array_pad($row, count($header), '');

    //                 if (count($row) == count($header)) {
    //                     $row = @array_combine($header, $row);

    //                     if ($row) {
    //                         Log::info("Combined Row {$index}: ", $row);

    //                         // Add default values
    //                         $row['user_id'] = auth()->id() ?? 1;
    //                         $row['contact_type_id'] = 1;
    //                         $row['status'] = 'active';

    //                         // Validate each row
    //                         $validator = Validator::make($row, [
    //                             'c_fname' => 'required|string',
    //                             'c_lname' => 'required|string',
    //                             'c_email' => 'required|email',
    //                             'c_phno' => 'required|string',
    //                             'user_id' => 'required|integer',
    //                             'contact_type_id' => 'required|integer',
    //                             'status' => 'required|string',
    //                         ]);

    //                         if ($validator->fails()) {
    //                             Log::warning("Validation failed for row {$index}. Skipping.");
    //                             $skippedCount++;
    //                         } else {
    //                             ContactImportData::create($row);
    //                             $insertedCount++;
    //                         }
    //                     } else {
    //                         Log::warning("Failed to combine Row {$index}. Skipping.");
    //                         $skippedCount++;
    //                     }
    //                 } else {
    //                     Log::warning("Row {$index} skipped due to mismatched column count.");
    //                     $skippedCount++;
    //                 }
    //             }
    //         }

    //         DB::commit();

    //         Log::info("CSV Import Completed. Inserted: {$insertedCount}, Skipped: {$skippedCount}");

    //         return redirect()->back()->with('success', "Contacts imported successfully. Inserted: {$insertedCount}, Skipped: {$skippedCount}");
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error during import: ' . $e->getMessage());

    //         return redirect()->back()->withErrors(['error' => 'Failed to import: ' . $e->getMessage() . ' at line ' . $e->getLine()]);
    //     }
    // }

/*import contact*/
public function storeMultipleContacts(Request $request)
{
    // Validate the uploaded file
    $validator = Validator::make($request->all(), [
        'file' => 'required|file',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Get the uploaded file
    $file = $request->file('file');

    // Read CSV and remove BOM if it exists
    $csvData = file_get_contents($file->getPathname());
    $csvData = preg_replace('/\x{FEFF}/u', '', $csvData);  // Remove BOM

    $rows = array_map('str_getcsv', explode("\n", $csvData));

    if (empty($rows) || count($rows) < 2) {
        return redirect()->back()->withErrors(['error' => 'Empty or invalid CSV file.']);
    }

    $header = array_map('trim', array_shift($rows));  // Trim header values

    // Initialize counter
    $insertedCount = 0;
    $curr_userId = auth()->id();

    foreach ($rows as $row) {
        $row = array_map('trim', $row);  // Trim each row value

        // Ensure row-column consistency before combining
        if (count($row) === count($header)) {
            $combined = @array_combine($header, $row);  // Suppress errors

            // Skip invalid rows
            if (!$combined || !is_array($combined)) {
                continue;
            }

            // Validate the row data
            $validator = Validator::make($combined, [
                'c_fname' => 'required|string',
                'c_lname' => 'required|string',
                'c_email' => 'required|email',
                'c_phno' => 'required|string',
                'user_id' => $curr_userId,
            ]);

            if ($validator->fails()) {
                continue;  // Skip invalid rows
            }

            // Insert into database
            ContactImportData::create($combined);
            $insertedCount++;
        }
    }

    echo "Total records inserted: $insertedCount";
    die();

    return redirect()->back()->with('success', "$insertedCount contacts imported successfully.");
}


/*end*/




    public function storeContact(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'c_fname'    => 'required|string|max:255',          // First name: required, string, max length 255
                'c_lname'    => 'required|string|max:255',          // Last name: required, string, max length 255
                'c_email'    => 'required|email|unique:users,email', // Email: required, valid email format, unique in users table
                'c_phno'     => 'required|digits:10',               // Phone number: required, exactly 10 digits
                'c_city'     => 'required|string|max:255',          // City: required, string, max length 255
                'c_state'    => 'required|string|max:255',          // State: required, string, max length 255
                //'c_timezone' => 'required|string',                  // Timezone: required, string (assuming it's a valid timezone identifier)
                'c_contact_type' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $curr_userId = auth()->id();


            $contact = [
                'c_fname' => $request->input('c_fname'),
                'c_lname' => $request->input('c_lname'),
                'c_email' => $request->input('c_email'),
                'c_phno' => $request->input('c_phno'),
                'c_city' => $request->input('c_city'),
                'c_state' => $request->input('c_state'),
                //'c_timezone' => $request->input('c_timezone'),
                'user_id' => $curr_userId,
                'contact_type_id' => $request->input('c_contact_type'),
            ];
            $addSingleContact = ContactImportData::create($contact);

            if ($addSingleContact) {
                return redirect()->back()->with('success', 'contact added successfully!');
            } else {
                return redirect()->back()->withErrors('Failed to add Contact')->withInput();
            }
        } catch (\Exception $e) {
            // Handle exceptions and return a proper error message
            return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()])->withInput();
        }
    }

    public function storeContactType(Request $request)
    {
        try {
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
                    return redirect()->back()->with('success', 'contact type updated successfully!');
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
        $curr_userId = auth()->id();

        // Find the contact type by its ID and user_id
        $contactType = ContactType::where('user_id', $curr_userId)
            ->where('id', $id)
            ->first();

        if ($contactType) {
            // Delete the contact type record
            $contactType->delete();
            // Redirect or return a success message
            return redirect()->back()->with('success', 'Contact type deleted successfully!');
        } else {
            // If not found, return an error message
            return redirect()->back()->with('error', 'Contact type not found!');
        }
    }



    public function updatePopulateContactType(Request $request, $id)
    {
        $curr_userId = auth()->id();

        $updateContactType = ContactType::where('user_id', $curr_userId)
            ->where('id', $id)
            ->first();

        $contactTypes = ContactType::where('user_id', $curr_userId)->get();

        return view('admin.pages.contact-type', compact('updateContactType', 'contactTypes'));
    }
}
