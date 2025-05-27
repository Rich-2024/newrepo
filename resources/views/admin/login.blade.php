<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Professional Login</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <style>
    @keyframes slide-background {
      0% {
        background-position: 0% center;
      }
      100% {
        background-position: 100% center;
      }
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

<!-- ✅ Use only the custom class for background here -->
<body class="min-h-screen animate-slide-background">

  <div class="min-h-screen flex items-center justify-center px-4 backdrop-blur-[2px] bg-black/30">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-2xl">

      <!-- Heading -->
      <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back</h2>
        <p class="text-gray-600">Please sign in to continue</p>
      </div>

      <!-- Display Laravel Errors -->
      @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
          <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Login Form -->
      <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div>
          <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
            Email
          </label>
          <input type="email" id="email" name="email" value="{{ old('email') }}"
            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700 placeholder-gray-400"
            placeholder="Enter your email" required autofocus>
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-gray-700 text-sm font-medium mb-2">
            Password
          </label>
          <div class="relative">
            <input type="password" id="password" name="password"
              class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700 placeholder-gray-400"
              placeholder="Enter your password" required>
            <button type="button" onclick="togglePassword()"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" aria-label="Toggle password">
              <span id="eyeIcon">👁️</span>
            </button>
          </div>
        </div>

        <!-- Remember & Forgot -->
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input type="checkbox" id="remember" name="remember"
              class="rounded bg-gray-50 border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
          </div>
          <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800">
            Forgot password?
          </a>
        </div>

        <!-- Submit -->
        <button type="submit"
          class="w-full py-3 px-4 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
          Sign In
        </button>
        <a href="/" style="text-align:center;">back</a>
      </form>

    </div>
  </div>

  <!-- Toggle Password Visibility -->
  <script>
    function togglePassword() {
      const passwordField = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.textContent = '🙈';
      } else {
        passwordField.type = 'password';
        eyeIcon.textContent = '👁️';
      }
    }
  </script>

</body>
</html>
