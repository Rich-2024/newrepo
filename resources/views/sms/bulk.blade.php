<!DOCTYPE html>
<html>
<head>
    <title>Send Bulk SMS</title>
</head>
<body>
    <h1>Send notification to Client</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

   <form method="POST" action="/send-bulk-sms">
    @csrf
    <textarea name="message" rows="4" cols="50" placeholder="Enter SMS message here...">{{ old('message') }}</textarea><br><br>
    <button type="submit">Send to Clients</button>
</form>

</body>
</html>
