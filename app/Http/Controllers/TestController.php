<?php

namespace App\Http\Controllers;

use App\Models\ContactType;
use App\Models\ContactImportData;
use App\Models\BlastAnswer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Mailgun\Mailgun;
use Illuminate\Support\Facades\Mail;

use Twilio\Rest\Client;



class TestController extends Controller
{

// FOR EMAIL MAILGUN AS
//     public function testEmail(){
   
//         // Include the Autoloader (see "Libraries" for install instructions)
//     //require env('APP_URL').'/vendor/autoload.php';
//   // Instantiate the client
//   $mg = Mailgun::create(config('services.mailgun.secret'));

//   // Compose and send your message
//   $result = $mg->messages()->send(config('services.mailgun.domain'), [
//       'from'    => 'Mailgun Sandbox <postmaster@' . config('services.mailgun.domain') . '>',
//       'to'      => 'System Admin <developer11.nextupgrad@gmail.com>',
//       'subject' => 'Hello System Admin, this is a testing email. Please do not reply',
//       'text'    => 'Congratulations System Admin, you just sent an email with Mailgun! You are truly awesome!',
//   ]);

//   // Optional: Show success message
//   return back()->with('success', 'Email sent successfully!');

// }


// public function testEmail()
// {
//     try {
//         $mg = Mailgun::create(config('services.mailgun.secret')); // Or add endpoint if needed

//         $mg->messages()->send(config('services.mailgun.domain'), [
//             'from'    => 'Mailgun Sandbox <postmaster@' . config('services.mailgun.domain') . '>',
//             'to'      => 'System Admin <developer11.nextupgrad@gmail.com>',
//             'subject' => 'Hello System Admin, this is a testing email. Please do not reply',
//             'text'    => 'Congratulations System Admin, you just sent an email with Mailgun! You are truly awesome!',
//         ]);

//         return back()->with('success', 'Email sent successfully!');
//     } catch (\Exception $e) {
//         return back()->with('error', 'Email sending failed: ' . $e->getMessage());
//     }
// }

// public function testEmail()
// {
//     try {
//         Mail::raw('Congratulations System Admin, you just sent an email with Mailgun! You are truly awesome!', function ($message) {
//             $message->to('akansha.nextupgrad@gmail.com')
//                     ->subject('Hello System Admin, this is a testing email. Please do not reply');
//         });

//         return back()->with('success', 'Email sent successfully using Mailgun!');
//     } catch (\Exception $e) {
//         return back()->with('error', 'Email sending failed: ' . $e->getMessage());
//     }
// }


// public function testEmail()
// {
//     $toEmail = 'akansha.nextupgrad@gmail.com';

//     $data = [
//         'title' => 'Test Email',
//         'body' => 'This is a test email sent via Mailgun using Laravel directly from the controller.'
//     ];

//     Mail::send([], [], function ($message) use ($toEmail, $data) {
//         $message->to($toEmail)
//                 ->from('developer11.nextupgrad@gmail.com', 'NextUpgrad Web Solutions')
//                 ->subject($data['title'])
//                 ->setBody($data['body'], 'text/html');
//     });

//     return "Mail sent to {$toEmail}";
// }

// public function testEmail(Request $request)
//     {
//         if ($request->isMethod('get')) {
//             return view('admin.pages.test');
//         }

//         $request->validate([
//             'email' => 'required|email',
//             'subject' => 'required|string',
//             'message' => 'required|string',
//         ]);

        
//         try {
//             Mail::send([], [], function ($message) use ($request) {
//                 $message->to($request->email)
//                         ->from('developer11.nextupgrad@gmail.com', 'NextUpgrad Web Solutions')
//                         ->subject($request->subject)
//                         ->setBody($request->message, 'text/html');
//             });

//             return back()->with('success', 'Email sent successfully to ' . $request->email);
//         } catch (\Exception $e) {
//             return back()->with('error', 'Failed to send email. Error: ' . $e->getMessage());
//         }
//     }

public function testEmail(Request $request)
{
    if ($request->isMethod('get')) {
        return view('admin.pages.test');
    }

    $request->validate([
        'email' => 'required|email',
        'subject' => 'required|string',
        'message' => 'required|string',
    ]);

    try {
        Mail::send([], [], function ($message) use ($request) {
            $message->to($request->email)
                    ->subject($request->subject)
                    ->setBody($request->message, 'text/html');
        });

        return back()->with('success', 'Email sent successfully to ' . $request->email);
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to send email. Error: ' . $e->getMessage());
    }
}
// END MAILGUN FUNCTION

// New Mailgun


// end

// SMS INTEGRARTION
// curl working with C. deyails
// public function testing()
//     {
//         $sid = 'AC23b0d526c4410fbffa10e7c9246db756';
//         $token = 'e857e6d27bbcbdac2a48630594d1af8c';
//         $from = '+18669636504';
//         // $to = '+916284522486'; // Your verified number
//         $to = '+917678981788'; // Your verified number
//         $body = 'Hello this is a test message';

//         $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";

//         $data = [
//             'To' => $to,
//             'From' => $from,
//             'Body' => $body
//         ];

//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_POST, true);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//         curl_setopt($ch, CURLOPT_USERPWD, "$sid:$token");

//         $response = curl_exec($ch);
//         $error = curl_error($ch);
//         curl_close($ch);

//         $result = json_decode($response, true);

//         if (isset($result['sid'])) {
//             return view('admin.pages.test', [
//                 'success' => true,
//                 'sid' => $result['sid'],
//                 'error' => null,
//             ]);
//         } else {
//             return view('admin.pages.test', [
//                 'success' => false,
//                 'sid' => null,
//                 'error' => $result['message'] ?? $error ?? 'Unknown error',
//             ]);
//         }
//     }

// curl working with M. deyails
// public function testing()
// {
//     $sid = 'AC9ff6ccbd3d3282722fba35a55ae08b27';
//     $token = '6f3a865acdccd51ff83193a633bce365'; // Replace with actual token
//     $from = '+18605129652';
//     $to = '+917678981788';
//     $body = 'test';

//     $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";

//     $data = [
//         'To' => $to,
//         'From' => $from,
//         'Body' => $body
//     ];

//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//     curl_setopt($ch, CURLOPT_USERPWD, "$sid:$token");

//     $response = curl_exec($ch);
//     $error = curl_error($ch);
//     curl_close($ch);

//     $result = json_decode($response, true);

//     if (isset($result['sid'])) {
//         return view('admin.pages.test', [
//             'success' => true,
//             'sid' => $result['sid'],
//             'error' => null,
//         ]);
//     } else {
//         return view('admin.pages.test', [
//             'success' => false,
//             'sid' => null,
//             'error' => $result['message'] ?? $error ?? 'Unknown error',
//         ]);
//     }
// }

// with webhook clickble yes/no & response save to db
public function testing(Request $request)
{
    // Static values
    $staticQuestionId = 6;
    $staticContactId = 158;

    // Handle replies via GET links
    if ($request->isMethod('get') && $request->has('reply') && $request->has('from')) {
        $from = $request->input('from');
        $reply = strtoupper(trim($request->input('reply')));

        if (in_array($reply, ['YES', 'NO'])) {
            // Save to DB
            BlastAnswer::create([
                'answer' => $reply,
                'question_id' => $staticQuestionId,
                'contact_id' => $staticContactId,
                'medium' => 'sms',
            ]);

            \Log::info("User {$from} clicked {$reply} via link.");
            return response("Thanks! We recorded your response: {$reply}");
        } else {
            return response("Invalid response.");
        }
    }

    // Handle SMS replies via POST (from Twilio webhook)
    if ($request->isMethod('post') && $request->has('From') && $request->has('Body')) {
        $from = $request->input('From');
        $body = strtoupper(trim($request->input('Body')));

        if (in_array($body, ['YES', 'NO'])) {
            // Save to DB
            BlastAnswer::create([
                'answer' => $body,
                'question_id' => $staticQuestionId,
                'contact_id' => $staticContactId, 
                'medium' => 'sms',
            ]);

            \Log::info("User {$from} replied via SMS: {$body}");
        } else {
            \Log::info("Unexpected SMS from {$from}: {$body}");
        }

        return response('<?xml version="1.0"?><Response><Message>Thanks for your response!</Message></Response>', 200)
            ->header('Content-Type', 'application/xml');
    }

    // Send SMS with clickable YES/NO links
  // Send SMS with clickable YES/NO links to multiple numbers
$sid = 'AC9ff6ccbd3d3282722fba35a55ae08b27';
$token = '6f3a865acdccd51ff83193a633bce365';
$from = '+18605129652';

$recipients = [
    '+917678981788',
    '+916284522486',
    '+919876543210',
]; // Add as many numbers as you want

$sent = [];
$failed = [];

foreach ($recipients as $to) {
    $yesLink = "https://53c50cd527.nxcli.io/make-it-blast/test?reply=YES&from=" . urlencode($to);
    $noLink  = "https://53c50cd527.nxcli.io/make-it-blast/test?reply=NO&from=" . urlencode($to);

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

return view('admin.pages.test', [
    'success' => count($sent) > 0,
    'sent' => $sent,
    'failed' => $failed,
]);
}
// END SMS FUNCTION
}
