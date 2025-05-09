<?php echo '<center><img src="' . asset('media/Blast Logo.png') . '" width="20%"><center>'; ?>

@php


use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\BlastAnswer;
 
$yes = request()->input('yes');
$no = request()->input('no');
$cde = request()->input('cde');
$qid = request()->input('qid');
 
 
try {
    $decrypted = Crypt::decrypt($cde);
} catch (DecryptException $e) {
    $decrypted = null;
}
 
$contact_id = null;
$answer = null;
 
if ($decrypted == $yes) {
    $contact_id = $yes;
    $answer = 'yes';
} elseif ($decrypted == $no) {
    $contact_id = $no;
    $answer = 'no';
   
}

if($qid && $contact_id){
 
    if ($contact_id && $decrypted) {
        // Check if the same question_id + contact_id already exists
        $exists = BlastAnswer::where('question_id', $qid)
                    ->where('contact_id', $contact_id)
                    ->exists();
    
        if (!$exists) {
            BlastAnswer::create([
                'answer' => $answer,
                'question_id' => $qid,
                'contact_id' => $contact_id,
                'medium' => 'email',
            ]);
            echo "<div class='main clrGr' ><p>Answer saved as $answer </p></div>";
        } else {
            echo "<div class='main clrRd'> <p>Answer already exists for this contact and question.</p></div>";
        }
    } else {

        $exists = BlastAnswer::where('question_id', $qid)
                    ->where('contact_id', $contact_id)
                    ->exists();
    
        if (!$exists) {
            BlastAnswer::create([
                'answer' => $answer,
                'question_id' => $qid,
                'contact_id' => $contact_id,
                'medium' => 'email',
            ]);
            echo "<div class='main clrGr'><p>Answer saved as $answer</p></div>";
        } else {
            echo "<div class='main clrRd'><p>Answer already exists for this contact and question.<p></div>";
        }
        
    }
}

@endphp

@if (request()->input('reply') && request()->input('from'))
    @php
        $from = request()->input('from');
        $reply = strtoupper(trim(request()->input('reply')));
        $question_id = request()->input('questionId');
        $contact_id = request()->input('contactId');
    @endphp

    @if (in_array($reply, ['YES', 'NO']))
        @php
            \App\Models\BlastAnswer::create([
                'answer' => $reply,
                'question_id' => $question_id,
                'contact_id' => $contact_id,
                'medium' => 'sms',
            ]);
        @endphp

        Thanks! We recorded your response: {{ $reply }}
    @else
        Invalid response.
    @endif
@endif


<a href="/make-it-blast"><button>Back to Login</button></a>
 
 <style>
    .main{
        width:fit-content;
        margin: 0 auto;
       
        padding:5px 10px;
        border-radius:5px;
    }

    .clrRd{
        background: #ff49499e;
    }

    .clrGr{
        background:rgba(33, 212, 16, 0.62);
    }
   
 </style>