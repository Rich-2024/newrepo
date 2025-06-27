<!DOCTYPE html>
<html>
<head>
    <title>Request OTP</title>
</head>
<body>
    <h1>Request OTP</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('otp.send') }}">
        @csrf
        <input type="text" name="contact" placeholder="Enter phone number" value="{{ old('contact') }}" required>
        <button type="submit">Send OTP</button>
    </form>
</body>
</html>
