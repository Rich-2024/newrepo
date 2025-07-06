<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create Account - LoanHubTracking $Mgt System</title>
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
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Create Account</h2>
        <p class="text-gray-600">Please fill in the details to sign up,your're currently in free Trial</p>
      </div>

      @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <div>
          <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Business Name</label>
          <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            required
            autofocus
            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700 placeholder-gray-400"
            placeholder="Your full name"
          />
        </div>

        <div>
          <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Business Email</label>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700 placeholder-gray-400"
            placeholder="Your email address"
          />
        </div>

        <div>
          <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
          <div class="relative">
            <input
              type="password"
              id="password"
              name="password"
              required
              class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700 placeholder-gray-400"
              placeholder="Create a password"
            />
            <button
              type="button"
              onclick="togglePassword()"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
              aria-label="Toggle password"
            >
              <span id="eyeIcon">👁️</span>
            </button>
          </div>
        </div>

        <div>
          <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">Confirm Password</label>
          <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            required
            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700 placeholder-gray-400"
            placeholder="Confirm your password"
          />
        </div>

        <!-- Contact (optional) -->
        <div>
          <label for="contact" class="block text-gray-700 text-sm font-medium mb-2">Business Contact </label>
          <input
            type="text"
            id="contact"
            name="contact"
            value="{{ old('contact') }}"
            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700 placeholder-gray-400"
            placeholder="Phone number"
          />
        </div>

        <!-- Admin Name -->
        <div>
          <label for="admin_name" class="block text-gray-700 text-sm font-medium mb-2"> Your Name</label>
          <input
            type="text"
            id="admin_name"
            name="admin_name"
            value="{{ old('admin_name') }}"
            required
            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700 placeholder-gray-400"
            placeholder="Admin name"
          />
        </div>

        <button
          type="submit"
          class="w-full py-3 px-4 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200"
        >
          Sign Up
        </button>

        <p class="text-center text-sm mt-4">
          Already have an account?
          <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Sign in</a>
        </p>
      </form>
    </div>
  </div>

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
