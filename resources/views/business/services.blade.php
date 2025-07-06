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

      <!-- Hamburger Button -->
      <button id="menu-toggle" class="md:hidden focus:outline-none text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
          viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Navigation -->
      <nav id="mobile-menu"
        class="hidden absolute top-full left-0 w-full bg-blue-900 md:static md:flex md:space-x-6 md:items-center md:w-auto md:bg-transparent">
        <a href="/" class="block px-4 py-2 hover:text-blue-300">Home</a>
        <a href="{{ route('price') }}" class="block px-4 py-2 hover:text-blue-300">Pricing</a>
        <a href="#services" class="block px-4 py-2 hover:text-blue-300">Services</a>
        <a href="{{ route('login') }}"
          class="block px-4 py-2 bg-white text-blue-900 rounded hover:bg-blue-100 transition md:bg-white md:inline">Login</a>
      </nav>
    </div>
  </header>

  <!-- Hero -->
  <section class="bg-blue-100 py-20 text-center">
    <h2 class="text-4xl font-bold text-blue-900 animate__animated animate__fadeInDown">Our Core Services</h2>
    <p class="text-gray-700 text-lg mt-4 max-w-2xl mx-auto">We provide intelligent loan management tools tailored for your business growth and financial organization.</p>
  </section>

  <!-- Services Grid -->
  <section id="services" class="py-20 container mx-auto px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

      <!-- Service 1 -->
      <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp">
        <div class="mb-4 text-blue-700">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M9 17v-6a2 2 0 012-2h6M9 17l-2.5-2.5M9 17l2.5-2.5" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-blue-900">Loan Application Management</h3>
        <p class="text-gray-600 mt-2">Track, approve, and manage customer loan applications with precision and speed.</p>
      </div>

      <!-- Service 2 -->
      <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp animate__delay-1s">
        <div class="mb-4 text-blue-700">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-9.33-5" />
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M13 17h-1v1a3 3 0 11-6 0v-1H5a2 2 0 01-2-2v-4a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2h-2z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-blue-900">Automated Reminders</h3>
        <p class="text-gray-600 mt-2">Send timely SMS/email reminders for upcoming and overdue payments to customers.</p>
      </div>

      <!-- Service 3 -->
      <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp animate__delay-2s">
        <div class="mb-4 text-blue-700">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 3v18h18M9 9h6v6H9z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-blue-900">Performance Reports</h3>
        <p class="text-gray-600 mt-2">Gain insights into your financial performance with auto-generated reports.</p>
      </div>

      <!-- Service 4 -->
      <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp animate__delay-3s">
        <div class="mb-4 text-blue-700">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 15v2m0-6a4 4 0 100 8 4 4 0 000-8zm0 0V5a2 2 0 114 0v2" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-blue-900">Secure Admin Dashboard</h3>
        <p class="text-gray-600 mt-2">Monitor all loan activities and user actions securely through your dashboard.</p>
      </div>

      <!-- Service 5 -->
      <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp animate__delay-4s">
        <div class="mb-4 text-blue-700">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M8 10h.01M12 10h.01M16 10h.01M21 16v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2a2 2 0 002 2h14a2 2 0 002-2z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-blue-900">Client Communication</h3>
        <p class="text-gray-600 mt-2">Engage with borrowers through integrated messaging tools for inquiries.</p>
      </div>

      <!-- Service 6 -->
      <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition animate__animated animate__fadeInUp animate__delay-5s">
        <div class="mb-4 text-blue-700">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 4v1m6.364 1.636l-.707.707M20 12h-1m-1.636 6.364l-.707-.707M12 20v-1m-6.364-1.636l.707-.707M4 12h1m1.636-6.364l.707.707" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-blue-900">Cloud Access</h3>
        <p class="text-gray-600 mt-2">Access your data from anywhere at any time—secure, fast, and always available.</p>
      </div>

    </div>
  </section>

  <!-- CTA -->
  <section class="bg-blue-900 text-white py-20 text-center px-4">
    <h2 class="text-3xl font-bold mb-4 animate__animated animate__fadeIn">Want to experience our services firsthand?</h2>
    <p class="mb-6 text-lg">Start your 6-month free trial today. No commitment, just real results.</p>
    <a href="{{ route('register') }}"
      class="bg-white text-blue-900 px-6 py-3 rounded-full hover:bg-gray-200 transition">Register for Free</a>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-900 text-white py-6 text-center">
    <p>&copy; 2025 FinanceHubTracker. All rights reserved.</p>
  </footer>

  <!-- Mobile Menu Toggle Script -->
  <script>
    const toggleBtn = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      mobileMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
      const isInside = mobileMenu.contains(e.target) || toggleBtn.contains(e.target);
      if (!isInside && !mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('hidden');
      }
    });

    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
    });
  </script>

</body>
</html>
