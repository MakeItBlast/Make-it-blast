<?php

namespace App\Http\Controllers;
use DOMDocument;
use App\Models\Blast;
use App\Models\BlastQuestion;
use App\Models\BlastAnswer;
use App\Models\Keyword;
use App\Models\UserMetaData;
use App\Models\ContactType;
use App\Models\ContactImportData;
use App\Models\Tempelate;
use App\Models\BlastSchedule;
use App\Models\UserResource;
use App\Models\BlastInvoice;
use App\Models\SystemValue;
use App\Models\BlastLog;
use App\Models\ContactTypeWithBlast;
use App\Models\ResourceWithBlast;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Mailgun\Mailgun;
use Illuminate\Support\Facades\Crypt;

//use Twilio\Rest\Client;   // not working becz of 2 client class

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BlastController extends Controller
{


public function createBlast(){

    $curr_userId = auth()->id();
    $contactTypes = ContactType::where('user_id',$curr_userId)->get();
    $contactList = ContactImportData::where('user_id',$curr_userId)->get();
    $tempelateStructures = Tempelate::where('user_id',$curr_userId)->where('status','active')->get();
    $links = UserResource::where('user_id',$curr_userId)->where('rsrc_type','link')->get();    
    $medias = UserResource::where('user_id',$curr_userId)->where('rsrc_type','image')->get();
    $footerMessage = SystemValue::where('system_key', 'footer_message')->value('system_val');

    return view('admin.pages.create-blast', compact('contactTypes','contactList','tempelateStructures','links', 'medias','footerMessage'));

}
   // store the blast
   public function storeBlast(Request $request)
   {
       try {
           $data = [
               'blastName_data'        => $request->blastName_data,
               'contact_type_data'     => json_decode($request->contact_type_data, true),
               'keywords_data'         => json_decode($request->keywords_data, true),
               'scheduleData_data'     => json_decode($request->scheduleData_data, true),
               'sendTo_data'           => json_decode($request->sendTo_data, true),
               'inputQuestion_data'    => $request->inputQuestion_data,
               'positionQuestion_data' => $request->positionQuestion_data,
               'summernote_data'       => $request->summernote_data,
           ];
   
           $validator = Validator::make($data, [
               'blastName_data'        => 'required|string|max:255',
               'contact_type_data'     => 'required|array',
               'keywords_data'         => 'nullable|array',
               'scheduleData_data'     => 'nullable|array',
               'sendTo_data'           => 'required|array',
               'inputQuestion_data'    => 'nullable|string|max:255',
               'positionQuestion_data' => 'nullable|string|max:255',
               'summernote_data'       => 'required|string',
           ]);


   
           if ($validator->fails()) {
               return response()->json([
                   'message' => $validator->errors(),
                   'status' => false,
               ], 200);
           }
   
           $curr_userId = auth()->id();
   
           $newBlastData = [
               'blast_name'          => $request->input('blastName_data'),
               'user_id'             => $curr_userId,
               'tempelate_structure' => $request->input('summernote_data'),
           ];
   
           $blast = Blast::create($newBlastData);
   
           if (!$blast) {
               return response()->json([
                   'status' => false,
                   'message' => 'Blast not created'
               ], 200);
           }
   
           // Add keywords
           $keywords = $data['keywords_data'];
           if ($keywords) {
               foreach ($keywords as $keyword) {
                   Keyword::create([
                       'keyword' => $keyword,
                       'blast_id' => $blast->id,
                       'status' => 'active',
                   ]);
               }
           }
   
           // Add question
           $blastQuestionId = null;
           if ($data['inputQuestion_data']) {
               $question = BlastQuestion::create([
                   'question' => $data['inputQuestion_data'],
                   'blast_id' => $blast->id,
                   'question_placing' => $data['positionQuestion_data'],
                   'status' => 'active',
               ]);
               $blastQuestionId = $question->id;
           }


           //add contactType connected with current blast
           $c_type = $data['contact_type_data'] ?? [];

           if (!empty($c_type)) {
               foreach ($c_type as $cont_type) {
                   ContactTypeWithBlast::create([
                       'contact_type_id' => $cont_type,
                       'user_id'         => auth()->id(),
                       'blast_id'        => $blast->id,
                   ]);
               }
           }

           //add resources connected with current blast

           $arr_res_conn_blast = $data['summernote_data'];
           $bl_id = $blast->id;
            $a = $this->extractAnchorsAndImages($arr_res_conn_blast, $bl_id);
            echo '<pre>';
                print_r($a);
            echo '</pre>';
           die();
        
           $r_connect = '';
           if($r_connect){
            foreach($r_connect as $resourceConnected){
                ResourceWithBlast::create([
                    'resource_id'   => $resourceConnected,
                    'user_id'       => auth()->id(),
                    'blast_id'      => $blast->id,
                ]);
            }
           }
           
   
           // Add schedules
           $scheduleData = $data['scheduleData_data'];
           if (!empty($scheduleData)) {
               foreach ($scheduleData as $schedule) {
                   BlastSchedule::create([
                       'blast_id' => $blast->id,
                       'user_id' => $curr_userId,
                       'date' => $schedule['date'],
                       'time' => $schedule['time'],
                       'time_zone' => $schedule['timezone'],
                   ]);
               }

                //fetching data from the db to find to whome this blst is to be sent - scheduled
                $getFilteredContacts = ContactImportData::where('user_id', $curr_userId)
                ->when(!empty($data['contact_type_data']), function ($query) use ($data) {
                    return $query->whereIn('contact_type_id', $data['contact_type_data']);
                })
                ->get();
            
   
               Blast::where('id', $blast->id)->update(['status' => 'scheduled']);
               $this->createInvoice($blast->id);

               //store log of blast in the db
               foreach ($getFilteredContacts as $filtered_data) {
                $addLogdata = BlastLog::create([
                    'blast_id'   => $blast->id,
                    'user_id'    => $curr_userId,
                    'contact_id' => $filtered_data->id,
                    'status'     => 'scheduled',
                ]);
            }
            
               return response()->json([
                   'status' => true,
                   'message' => 'Your blast is scheduled'
               ], 200);
           }

          
          $sendMsgtoFront = '';
           // If no schedule, send immediately
           if (in_array('emailMessage', $data['sendTo_data']) && $data['summernote_data']) {
               $mail_sent = $this->sendEmailTOUsers(
                   $data['summernote_data'],
                   $data['inputQuestion_data'],
                   $data['positionQuestion_data'],
                   $blastQuestionId,
                   $data['contact_type_data'],
                   $blast->id,
               );

               $sendMsgtoFront .= ' Mail sent Successfully';

            }

                  //  Send SMS Immediately
        if (in_array('smsMessage', $data['sendTo_data'])) {
           
            $smsRespoSend =  $this->storeSmsReplies($blastQuestionId, $data['contact_type_data']);
            
            $sendMsgtoFront .= ' SMS sent Successfully';

             }


   
               if ($mail_sent['status'] === 'success'  || $smsRespoSend['status'] === 'success' ) {
                   Blast::where('id', $blast->id)->update(['status' => 'sent']);
                   $this->createInvoice($blast->id);
   
                   return response()->json([
                       'status' => true,
                       'message' => $sendMsgtoFront,
                       'report' => 'e-mail report : '.json_encode($mail_sent) . 'SMS report : ' . json_encode($smsRespoSend),
                   ], 200);
               } else {
                   return response()->json([
                       'status' => false,
                       'message' => 'Blast not sent',
                       'report' => 'e-mail report : '.json_encode($mail_sent) . 'SMS report : ' . json_encode($smsRespoSend),
                   ], 200);
               }
           

         
     


           return response()->json([
               'status' => true,
               'message' => 'Blast saved but not sent (no schedule or email target)',
           ], 200);
   
       } catch (\Exception $e) {
           return response()->json([
               'status' => false,
               'message' => 'Something went wrong: ' . $e->getMessage(),
               'line' => $e->getLine()
           ], 200);
       }
   }

   //add data to connection table of link, media
   public function extractAnchorsAndImages($htmlContent, $blast_id)
   {
       libxml_use_internal_errors(true); // Suppress DOM parsing warnings
   
       $dom = new DOMDocument();
       $dom->loadHTML($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
   
       $anchors = [];
       $images = [];
   
       // Process anchor tags
       foreach ($dom->getElementsByTagName('a') as $aTag) {
           $href = trim($aTag->getAttribute('href'));
           $text = trim($aTag->textContent);
           $data_id = $aTag->getAttribute('data-id');
   
           if ($data_id && $this->isValidResource($data_id)) {
               ResourceWithBlast::firstOrCreate([
                   'resource_id' => $data_id,
                   'user_id' => auth()->id(),
                   'blast_id' => $blast_id,
               ]);
           }
   
           // Only add anchors that have href
           if ($href) {
               $anchors[] = [
                   'href' => $href,
                   'text' => $text,
                   'data_id' => $data_id ?: null,
               ];
           }
       }
   
       // Process image tags
       foreach ($dom->getElementsByTagName('img') as $imgTag) {
           $src = trim($imgTag->getAttribute('src'));
           $alt = trim($imgTag->getAttribute('alt'));
           $data_id = $imgTag->getAttribute('data-id');
   
           if ($data_id && $this->isValidResource($data_id)) {
               ResourceWithBlast::firstOrCreate([
                   'resource_id' => $data_id,
                   'user_id' => auth()->id(),
                   'blast_id' => $blast_id,
               ]);
           }
   
           if ($src) {
               $images[] = [
                   'src' => $src,
                   'alt' => $alt,
                   'data_id' => $data_id ?: null,
               ];
           }
       }
   
       return [
           'anchors' => $anchors,
           'images' => $images,
       ];
   }
   
   /**
    * Check if the resource ID belongs to the current user
    */
   protected function isValidResource($id)
   {
       return UserResource::where('id', $id)
                          ->where('user_id', auth()->id())
                          ->exists();
   }
   
   
    // with webhook clickble yes/no & response save to db
    public function storeSmsReplies($qid,$contact_type_arr)
    {
     $current_id = auth()->id();
     $getClientUsers = ContactImportData::where('user_id', $current_id)
     ->when($contact_type_arr, function ($query) use ($contact_type_arr) {
         return $query->whereIn('contact_type_id', $contact_type_arr);
         })->get(); // This returns full Eloquent model instances

        // ✅ Send SMS with clickable YES/NO links to multiple numbers
        $sid = 'AC9ff6ccbd3d3282722fba35a55ae08b27';
        $token = '6f3a865acdccd51ff83193a633bce365';
        $from = '+18605129652';
        
        $recipients = [
            '+917678981788',
            '+916284522486',
        ];

        
        $sent = [];
        $failed = [];
        
        foreach ($recipients as $to) {
            $yesLink = "https://53c50cd527.nxcli.io/make-it-blast/store-replies?reply=YES&from=" . urlencode($to) . '&questionId=' .$qid. '&contactId='.'$getClientUsers->id';
            $noLink  = "https://53c50cd527.nxcli.io/make-it-blast/store-replies?reply=NO&from=" . urlencode($to) . '&questionId=' .$qid. '&contactId='.'$getClientUsers->id';
        
            $body = "Do you agree?\nReply YES: $yesLink\nReply NO: $noLink";
        
            $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";
        
            $data = [
                'To' => $to,
                'From' => $from,
                'Body' => $body
            ];
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_USERPWD, "$sid:$token");
        
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
        
            \Log::info("Twilio SMS Response to {$to}: " . $response);
        
            $result = json_decode($response, true);
        
            if (isset($result['sid'])) {
                $sent[] = ['to' => $to, 'sid' => $result['sid']];
            } else {
                $failed[] = ['to' => $to, 'error' => $result['message'] ?? $error ?? 'Unknown error'];
            }
    }


        $responseOfSMSFunction = [
            'success' => count($sent) > 0,
            'sent' => $sent,
            'failed' => $failed,
            'status' => 'success',
        ];

        return $responseOfSMSFunction;
    } 
 

//send email fucntion
public function sendEmailTOUsers($s_note_data, $question, $q_position, $blastQuestionId, $contact_type_arr,$blast_id)
{
    try {


        $current_id = auth()->id();

        // $getClientUsersEmails = ContactImportData::where('user_id', $current_id)
        //     ->when($contact_type_arr, function ($query) use ($contact_type_arr) {
        //         return $query->whereIn('contact_type_id', $contact_type_arr);
        //     })
        //     ->pluck('c_email', 'id');

        $getClientUsersEmails = ContactImportData::where('user_id', $current_id)
                ->when($contact_type_arr, function ($query) use ($contact_type_arr) {
                    return $query->whereIn('contact_type_id', $contact_type_arr);
                })
                ->get(); // This returns full Eloquent model instances


        $footerMessage = SystemValue::where('system_key', 'footer_message')->value('system_val') ?? '';
        $successCount = 0;
        $failedEmails = [];

        foreach ($getClientUsersEmails as $data) {
            if (!filter_var($data->c_email, FILTER_VALIDATE_EMAIL)) {
                $failedEmails[] = ['email' => $data->c_email, 'error' => 'Invalid email format'];
                continue;
            }

            $replacements = [
                '[First Name]' => $data->c_fname,
                '[Last Name]' => $data->c_lname,
                '[Email]' => $data->c_email,
                '[Phone Number]' => $data->c_phno,
            ];

            $finalEmailContent = str_replace(array_keys($replacements), array_values($replacements), $s_note_data);

            try {
                $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = env('MAIL_HOST');
                $mail->SMTPAuth = true;
                $mail->Username = env('MAIL_USERNAME');
                $mail->Password = env('MAIL_PASSWORD');
                $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
                $mail->Port = env('MAIL_PORT', 587);

                $mail->setFrom('developer11.nextupgrad@gmail.com', 'NextUpgrad Web Solutions');
                $mail->addAddress($data->c_email);
                $mail->addBCC('akansha.nextupgrad@gmail.com');

                $mail->isHTML(true);
                $mail->Subject = 'Test Email';

                $domain = request()->getHost() . '/make-it-blast/store-replies';
                $encrypted_user_id = Crypt::encrypt($data->id);
                $positive_resp = $domain . '?yes=' . $data->id . '&cde=' . $encrypted_user_id . '&qid=' . $blastQuestionId;
                $negative_respo = $domain . '?no=' . $data->id . '&cde=' . $encrypted_user_id . '&qid=' . $blastQuestionId;

                // Build email body
                if ($question) {
                    if ($q_position === 'up') {
                        $mail->Body = "Please answer the question:<br><strong>$question</strong><br>";
                        $mail->Body .= "<a href='$positive_resp' style='padding: 8px 12px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;'>Yes</a>&nbsp;";
                        $mail->Body .= "<a href='$negative_respo' style='padding: 8px 12px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 5px;'>No</a><br>";
                        $mail->Body .= $finalEmailContent . "<br>" . $footerMessage;
                    } else {
                        $mail->Body = $finalEmailContent . "<br><br>Please answer the question:<br><strong>$question</strong><br>";
                        $mail->Body .= "<a href='$positive_resp' style='padding: 8px 12px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;'>Yes</a>&nbsp;";
                        $mail->Body .= "<a href='$negative_respo' style='padding: 8px 12px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 5px;'>No</a><br>";
                        $mail->Body .= $footerMessage;
                    }
                } else {
                    $mail->Body = $finalEmailContent . "<br>" . $footerMessage;
                }

                $mail->send();
                $successCount++;


                // store enteries log to db   - when sending it to quee then change te status to pending
               
                    $addLogdata = BlastLog::create([
                        'blast_id'   => $blast_id,
                        'user_id'    => $current_id,
                        'contact_id' => $data->id,
                        'status'     => 'sent',
                    ]);
                
                
            } catch (\Exception $ex) {
                $failedEmails[] = ['email' => $data->c_email, 'error' => $ex->getMessage()];
            }
        }

        return [
            'status' => 'success',
            'successCount' => $successCount,
            'totalEmails' => count($getClientUsersEmails),
            'failedEmails' => $failedEmails
        ];

    } catch (\Exception $e) {
        return [
            'status' => 'fail',
            'error' => $e->getMessage()
        ];
    }
}


    //store question to db
    public function storeQuestions(Request $request){
         try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'question' => 'required|string|max:255',
                'blast_id' => 'required|integer|exists:blasts,id|unique:blasts,id', 
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

          

            // Construct an associative array for insertion
            $newQuestion = [
                'question' => $request->input('question'),
                'blast_id' => $request->input('blast_id'),
            ];


            // Create a new record in the database
            $addNewQuestion = BlastQuestion::create($newQuestion);

            if($addNewQuestion){
                return response()->json([
                    'message' => 'Question Added Successfully',
                    'status' => 'success',
                    'data' => $addNewQuestion,
                ], 201);
            }else{
                return response()->json([
                    'message' => 'Question Not Added',
                    'status' => 'fail',
                   
                ], 201);
            }
           

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }  

    public function storeAnswere(Request $request){
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'answer' => 'required|string|max:255',
                'blast_id' => 'required|integer|exists:blasts,id', 
                'contact_id' => 'required|integer|exists:ContactImportData,id', 
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

          

            // Construct an associative array for insertion
            $newAnswer = [
                'answer' => $request->input('question'),
                'blast_id' => $request->input('blast_id'),
                'contact_id' => $request->input('contact_id'),
            ];


            // Create a new record in the database
            $addNewAnswer = BlastAnswer::create($newAnswer);

            if($addNewAnswer){
                return response()->json([
                    'message' => 'Answer Added Successfully',
                    'status' => 'success',
                ], 201);
            }else{
                return response()->json([
                    'message' => 'Answer Not Added',
                    'status' => 'fail', 
                ], 201);
            }
           

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function storeKeyword(Request $request){
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'keyword' => 'required|string|max:255',
                'blast_id' => 'required|integer|exists:blasts,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

          

            // Construct an associative array for insertion
            $newKeyword = [
                'keyword' => $request->input('question'),
                'blast_id' => $request->input('blast_id'),
            ];


            // Create a new record in the database
            $addNewKeyword = Keyword::create($newKeyword);

            if($addNewKeyword){
                return response()->json([
                    'message' => 'Keyword Added Successfully',
                    'status' => 'success',
                ], 201);
            }else{
                return response()->json([
                    'message' => 'Keyword Not Added',
                    'status' => 'fail', 
                ], 201);
            }
           

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }
 

    public function getContactUsingContType(Request $request){
        print_r($request->items);
        $curr_userId = auth()->id();
        $contactTypes = ContactType::where('user_id',$curr_userId)->where('contact_type',$request->items[0])->get();
        print_r($contactTypes);

        $getContactList = ContactImportData::where('user_id', $curr_userId)->where('contact_type',$request->items[0])->get();

        print_r($getContactList);

    }

    public function storeTempStructureToBlastTbl(Request $request)
    {
        print_r($request->structure);
        
        $curr_userId = auth()->id();
        $randomNumber = mt_rand(1, 9999);
        
        $saveStructure = Tempelate::create([
            'template_structure' => $request->structure,
            'template_by' => 'user',
            'user_id' => $curr_userId,
            'temp_name' => 'Blas Structure ' . $randomNumber,
        ]);
    }

    public function getTempStructUsingId(Request $request)
    {
         
        $curr_userId = auth()->id();
        $getTempStructDataUsingId = Tempelate::where('user_id', $curr_userId)
            ->where('id', $request->idOfStructure)
            ->first();

       // print_r($getTempStructDataUsingId);

        return $getTempStructDataUsingId;
        
    }

    public function storeKeywordsToDB(Request $request){
        $request->addKeywords;
        print_r($request->addKeywords);
        $curr_userId = auth()->id();
        // $storeKeyWordsToDb = Keyword::create([
        //     'keyword' => 
        // ])
    }

    //enhance the data 
    public function enhancePrompt(Request $request)
    {
        //print_r($request->rawdata);
        $client = new Client();
        $response = $client->post('https://api-inference.huggingface.co/models/grammarly/coedit-large', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'inputs' => $request->input('rawdata'),
                'parameters' => [
                    'max_length' => 100, // Maximum length of the generated text
                    'num_return_sequences' => 1, // Number of enhanced outputs
                    'temperature' => 0.7, // Creativity level (0.7 is balanced)
                ],
            ],
        ]);
     
        $responseBody = json_decode($response->getBody(), true);
        return response()->json($responseBody[0]['generated_text']);
        //return $response;
    }

    public function createInvoice(int $blastId): string
    {
        $usr_id = auth()->id();
        $prefix = 'BLAST-';
        $blastInvoice = $prefix . str_pad($blastId, 6, '0', STR_PAD_LEFT);
    
        $createBlastInvoice = BlastInvoice::create([
            'user_id' => $usr_id,
            'blast_invoice_num' => $blastInvoice,
            'blast_id' => $blastId,
        ]);
    
        if (!$createBlastInvoice) {
            throw new \Exception("Failed to create invoice for blast ID: $blastId");
        }
    
        return $blastInvoice;
    }
    
    //download replies
    public function downloadReplies(Request $request)
    {
        try {
            $userId = auth()->id();
            if (!$userId) {
                return redirect()->back()->with('error', 'No user is logged in.');
            }

            $blastAnswers = BlastAnswer::with(['contact', 'question.blast']) // include contact and blast
                ->whereHas('contact.user', function ($query) use ($userId) {
                    $query->where('id', $userId);
                })
                ->get();

             

            if ($blastAnswers->isEmpty()) {
              
                return redirect()->route('dashboard')->with('error', 'No answers available.');
              
             
            }
           

            $filename = "blast_answers.csv";

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function () use ($blastAnswers) {
                $handle = fopen('php://output', 'w');

                // Header row
                fputcsv($handle, ['Blast Title', 'Contact Name', 'Question Text', 'Answer','Medium']);

                // Data rows
                foreach ($blastAnswers as $answer) {
                    fputcsv($handle, [
                        $answer->question->blast->blast_name ?? '',
                        $answer->contact->c_fname . ' ' . $answer->contact->c_lname ?? '',
                        $answer->question->question ?? '',
                        $answer->answer,
                        $answer->medium,
                    ]);
                }

                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => 'Something went wrong while exporting replies.',
                'message' => $e->getMessage()
            ]);
        }
    }

    
}
