<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password</title>
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

<body class="min-h-screen animate-slide-background">
  <div class="min-h-screen flex items-center justify-center px-4 backdrop-blur-[2px] bg-black/30">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-2xl">

      <!-- Heading -->
      <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Reset Your Password</h2>
        <p class="text-gray-600">Enter your new password below</p>
      </div>

      <!-- Laravel Errors -->
      @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
          <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Reset Password Form -->
      <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email -->
        <div>
          <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email</label>
          <input type="email" name="email" id="email" value="{{ old('email') }}" required
            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700"
            placeholder="Enter your email">
        </div>

        <!-- New Password -->
        <div>
          <label for="password" class="block text-gray-700 text-sm font-medium mb-2">New Password</label>
          <div class="relative">
            <input type="password" name="password" id="password" required
              class="w-full px-4 py-3 pr-10 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700"
              placeholder="New password">
            <button type="button" onclick="togglePassword('password', 'eyeIcon1')"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
              aria-label="Toggle password">
              <span id="eyeIcon1">👁️</span>
            </button>
          </div>
        </div>

        <!-- Confirm Password -->
        <div>
          <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">Confirm Password</label>
          <div class="relative">
            <input type="password" name="password_confirmation" id="password_confirmation" required
              class="w-full px-4 py-3 pr-10 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700"
              placeholder="Confirm password">
            <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
              aria-label="Toggle confirm password">
              <span id="eyeIcon2">👁️</span>
            </button>
          </div>
        </div>

        <!-- Submit -->
        <button type="submit"
          class="w-full py-3 px-4 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
          Reset Password
        </button>

        <a href="{{ route('login') }}" class="block text-center text-sm text-blue-600 hover:text-blue-800 mt-4">
          Back to Login
        </a>
      </form>
    </div>
  </div>

  <!-- Toggle Password Visibility -->
  <script>
    function togglePassword(fieldId, iconId) {
      const field = document.getElementById(fieldId);
      const icon = document.getElementById(iconId);
      if (field.type === 'password') {
        field.type = 'text';
        icon.textContent = '🙈';
      } else {
        field.type = 'password';
        icon.textContent = '👁️';
      }
    }
  </script>
</body>
</html>
