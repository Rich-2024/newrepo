<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OTP Verification</title>
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

    .btn-clicked {
      transform: translateY(2px);
      box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
      background-color: #2563eb; /* Slightly darker blue */
    }
  </style>
</head>

<body class="min-h-screen animate-slide-background">

  <div class="min-h-screen flex items-center justify-center px-4 backdrop-blur-[2px] bg-black/30">
    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-2xl">

      <!-- Heading -->
      <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">OTP Verification</h2>
        <p class="text-gray-600">Enter the OTP sent to your email</p>
      </div>

      <!-- Messages -->
      @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
          {{ $errors->first() }}
        </div>
      @endif

      <!-- OTP Form -->
      <form method="POST" action="{{ route('otp.verify') }}" class="space-y-6">
        @csrf
        <div>
          <label for="otp" class="block text-gray-700 text-sm font-medium mb-2">OTP Code</label>
          <input type="text" name="otp" id="otp" placeholder="Enter OTP"
            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700"
            required>
        </div>

        <button id="verifyBtn" type="submit"
          class="w-full py-3 px-4 bg-blue-600 text-white rounded-lg font-semibold shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">
          Verify OTP
        </button>
      </form>

      <!-- Resend -->
   <form method="POST" action="{{ route('otp.resend') }}" class="mt-4 text-center">
  @csrf
  <button
    type="submit"
    id="resendBtn"
    class="text-sm text-blue-600 hover:text-blue-800 underline transition duration-150">
    Resend OTP
  </button>
</form>

<style>
  .btn-clicked {
    transform: translateY(1px);
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.15s ease;
  }
</style>
<script>
  const resendBtn = document.getElementById('resendBtn');

  resendBtn.addEventListener('click', function () {
    resendBtn.classList.add('btn-clicked');
    setTimeout(() => {
      resendBtn.classList.remove('btn-clicked');
    }, 150); // Effect lasts 150ms
  });
</script>

    </div>
  </div>

  <!-- Optional: Simulate button click visual effect -->
  <script>
    const button = document.getElementById('verifyBtn');

    // Simulate visual click effect (optional, or can be used on real click)
    button.addEventListener('click', function () {
      button.classList.add('btn-clicked');
      setTimeout(() => {
        button.classList.remove('btn-clicked');
      }, 150); // Return to normal after 150ms
    });

    // To auto-show it as clicked on page load (optional, demo purpose)
    // window.addEventListener('load', () => {
    //   button.classList.add('btn-clicked');
    //   setTimeout(() => button.classList.remove('btn-clicked'), 150);
    // });
  </script>

</body>
</html>
