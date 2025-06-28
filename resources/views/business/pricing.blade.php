<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FinanceHubTracker - Pricing</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-50 font-sans">

  <!-- Header -->
  <header class="bg-blue-900 text-white p-5 shadow-md sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-bold">FinanceHubTracker</h1>
      <nav class="space-x-6">
        <a href="/" class="hover:text-blue-300">Home</a>
        <a href="#pricing" class="hover:text-blue-300">Pricing</a>
        <a href="{{ route('login') }}" class="bg-white text-blue-900 px-4 py-2 rounded hover:bg-blue-100 transition">Login</a>
      </nav>
    </div>
  </header>

  <!-- Pricing Section -->
  <section id="pricing" class="bg-gray-100 py-20 px-4">
    <div class="container mx-auto text-center">
      <h2 class="text-4xl font-bold text-blue-900 mb-0 animate__animated animate__fadeInDown">Simple, Transparent Pricing</h2>
      <p class="text-gray-600 mb-10 max-w-2xl mx-auto animate__animated animate__fadeInUp">
        Enjoy full access to FinanceHubTracker for 6 months free. Upgrade anytime to continue smart loan management.
      </p>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Free Trial -->
        <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp">
          <div class="text-sm text-green-600 font-semibold mb-2">🎁 For New Users</div>
          <h3 class="text-xl font-bold text-blue-800 mb-4">6-Month Free Trial</h3>
          <p class="text-3xl font-extrabold text-blue-900">UGX 0</p>
          <ul class="text-gray-600 mt-4 space-y-2">
            <li>✅ Full access</li>
            <li>✅ No payment info required</li>
            <li>✅ Cancel anytime</li>
          </ul>
          <a href="{{ route('register') }}" class="mt-6 inline-block bg-blue-700 text-white px-5 py-2 rounded-full hover:bg-blue-800 transition">Get Started</a>
        </div>

        <!-- Monthly Plan -->
        <div class="bg-white p-8 rounded-lg shadow border-2 border-blue-600 hover:shadow-lg transition animate__animated animate__fadeInUp animate__delay-1s">
          <div class="text-sm text-blue-600 font-semibold mb-2">💼 Ideal for small offices</div>
          <h3 class="text-xl font-bold text-blue-800 mb-4">Monthly Plan</h3>
          <p class="text-3xl font-extrabold text-blue-900">UGX 50,000<span class="text-lg text-gray-600">/mo</span></p>
          <ul class="text-gray-600 mt-4 space-y-2">
            <li>✅ Unlimited usage</li>
            <li>✅ Priority email support</li>
            <li>✅ Monthly billing</li>
          </ul>
          <a href="#" class="mt-6 inline-block bg-blue-700 text-white px-5 py-2 rounded-full hover:bg-blue-800 transition">Subscribe</a>
        </div>

        <!-- Annual Plan -->
        <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp animate__delay-2s">
          <div class="text-sm text-purple-600 font-semibold mb-2">📅 Best Value</div>
          <h3 class="text-xl font-bold text-blue-800 mb-4">Annual Plan</h3>
          <p class="text-3xl font-extrabold text-blue-900">UGX 600,000<span class="text-lg text-gray-600">/yr</span></p>
          <ul class="text-gray-600 mt-4 space-y-2">
            <li>✅ Save 2 months</li>
            <li>✅ Full features unlocked</li>
            <li>✅ Annual billing</li>
          </ul>
          <a href="#" class="mt-6 inline-block bg-blue-700 text-white px-5 py-2 rounded-full hover:bg-blue-800 transition">Subscribe Yearly</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-900 text-white py-6 text-center">
    <p>&copy; 2025 FinanceHubTracker. All rights reserved.</p>
  </footer>

</body>

</html>
