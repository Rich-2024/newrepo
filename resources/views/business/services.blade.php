<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FinanceHubTracker - Our Services</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-50 font-sans">

  <!-- Header -->
  <header class="bg-blue-900 text-white p-5 sticky top-0 z-50 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-bold">FinanceHubTracker</h1>
      <nav class="space-x-6">
        <a href="/" class="hover:text-blue-300">Home</a>
        <a href="{{ route('price') }}" class="hover:text-blue-300">Pricing</a>
        <a href="#services" class="hover:text-blue-300">Services</a>
        <a href="{{ route('login') }}" class="bg-white text-blue-900 px-4 py-2 rounded hover:bg-blue-100 transition">Login</a>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-blue-100 py-20 text-center">
    <h2 class="text-4xl font-bold text-blue-900 animate__animated animate__fadeInDown">Our Core Services</h2>
    <p class="text-gray-700 text-lg mt-4 max-w-2xl mx-auto">We provide intelligent loan management tools tailored for your business growth and financial organization.</p>
  </section>

  <!-- Services Grid -->
  <section id="services" class="py-20 container mx-auto px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

      <!-- Service 1 -->
      <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp">
        <div class="text-4xl mb-4 text-blue-700">📋</div>
        <h3 class="text-xl font-semibold text-blue-900">Loan Application Management</h3>
        <p class="text-gray-600 mt-2">Track, approve, and manage customer loan applications with precision and speed.</p>
      </div>

      <!-- Service 2 -->
      <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp animate__delay-1s">
        <div class="text-4xl mb-4 text-blue-700">🔔</div>
        <h3 class="text-xl font-semibold text-blue-900">Automated Reminders</h3>
        <p class="text-gray-600 mt-2">Send timely SMS/email reminders for upcoming and overdue payments to customers.</p>
      </div>

      <!-- Service 3 -->
      <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp animate__delay-2s">
        <div class="text-4xl mb-4 text-blue-700">📊</div>
        <h3 class="text-xl font-semibold text-blue-900">Performance Reports</h3>
        <p class="text-gray-600 mt-2">Gain insights into your financial performance with auto-generated daily, weekly, or monthly reports.</p>
      </div>

      <!-- Service 4 -->
      <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp animate__delay-3s">
        <div class="text-4xl mb-4 text-blue-700">🔐</div>
        <h3 class="text-xl font-semibold text-blue-900">Secure Admin Dashboard</h3>
        <p class="text-gray-600 mt-2">Monitor all loan activities and user actions securely through your personalized dashboard.</p>
      </div>

      <!-- Service 5 -->
      <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp animate__delay-4s">
        <div class="text-4xl mb-4 text-blue-700">💬</div>
        <h3 class="text-xl font-semibold text-blue-900">Client Communication</h3>
        <p class="text-gray-600 mt-2">Engage with borrowers through integrated messaging tools for inquiries and follow-ups.</p>
      </div>

      <!-- Service 6 -->
      <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp animate__delay-5s">
        <div class="text-4xl mb-4 text-blue-700">🌐</div>
        <h3 class="text-xl font-semibold text-blue-900">Cloud Access</h3>
        <p class="text-gray-600 mt-2">Access your data from anywhere at any time—secure, fast, and always available.</p>
      </div>

    </div>
  </section>

  <!-- Call to Action -->
  <section class="bg-blue-900 text-white py-20 text-center px-4">
    <h2 class="text-3xl font-bold mb-4 animate__animated animate__fadeIn">Want to experience our services firsthand?</h2>
    <p class="mb-6 text-lg">Start your 6-month free trial today. No commitment, just real results.</p>
    <a href="{{ route('register') }}" class="bg-white text-blue-900 px-6 py-3 rounded-full hover:bg-gray-200 transition">Register for Free</a>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-900 text-white py-6 text-center">
    <p>&copy; 2025 FinanceHubTracker. All rights reserved.</p>
  </footer>

</body>

</html>
