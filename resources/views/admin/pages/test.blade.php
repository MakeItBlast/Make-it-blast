<!-- <!DOCTYPE html>
<html>
<head>
    <title>Twilio SMS Test</title>
</head>
<body>
    <h1>Twilio SMS Test Result</h1>

    @if(isset($success) && $success)
        <h3 style="color: green;">Messages sent successfully:</h3>
        <ul>
            @foreach ($sent as $msg)
                <li>{{ $msg['to'] }} - SID: {{ $msg['sid'] }}</li>
            @endforeach
        </ul>
    @else
        <h3 style="color: red;">Some messages failed to send.</h3>
    @endif

    @if (!empty($failed))
        <h4>Failures:</h4>
        <ul>
            @foreach ($failed as $fail)
                <li>{{ $fail['to'] }} - {{ $fail['error'] }}</li>
            @endforeach
        </ul>
    @endif
</body>
</html> -->


<!DOCTYPE html>
<html>
<head>
    <title>Send Test Email</title>
</head>
<body>
    <h2>Send Email via Mailgun</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ url('send-emails') }}">
        @csrf

        <label for="email">Recipient Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="subject">Subject:</label><br>
        <input type="text" name="subject" required><br><br>

        <label for="message">Message:</label><br>
        <textarea name="message" rows="5" required></textarea><br><br>

        <button type="submit">Send Email</button>
    </form>
</body>

</html>
@php
    foreach($globalCategories as $a){
        print_r($a->name);
    }
@endphp