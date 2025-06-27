<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <style>
    @keyframes slide-background {
      0% { background-position: 0% center; }
      100% { background-position: 100% center; }
    }
    .animate-slide-background {
      animation: slide-background 30s linear infinite;
      background-image: url('https://images.pexels.com/photos/7567434/pexels-photo-7567434.jpeg');
      background-repeat: no-repeat;
      background-size: 200% auto;
      background-position: 0% center;
    }
  </style>
</head>
<body class="min-h-screen animate-slide-background">
  <div class="min-h-screen flex items-center justify-center px-4 backdrop-blur-[2px] bg-black/30">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-2xl">

      <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Forgot Your Password?</h2>
        <p class="text-gray-600">Enter your email to receive a reset link.</p>
      </div>

      @if (session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm" role="alert">
          {{ session('status') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
          <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
          <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
          <input type="email" name="email" id="email" required autofocus
            class="w-full px-4 py-3 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700 placeholder-gray-400"
            placeholder="you@example.com" />
        </div>

        <button type="submit"
          class="w-full py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
          Send Password Reset Link
        </button>

      </form>

      <a href="{{ route('login') }}" class="block text-center text-sm text-blue-600 hover:text-blue-800 mt-6">
        Back to Login
      </a>
    </div>
  </div>
</body>
</html>
