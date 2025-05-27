<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FinanceHubTracker - Learn More</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
  <style>
    html {
      scroll-behavior: smooth;
    }

    .feature-box {
      display: none;
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
    }

    .feature-box.visible {
      display: block;
      opacity: 1;
    }
  </style>
</head>

<body class="bg-gray-50 font-sans">

  <!-- Header -->
  <header class="bg-blue-900 text-white p-5 sticky top-0 z-50 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-bold">FinanceHubTracker</h1>
      <nav class="space-x-6">
        <a href="#features" class="hover:text-blue-300">Features</a>
        <a href="#benefits" class="hover:text-blue-300">Benefits</a>
        <a href="/" class="bg-white text-blue-900 px-4 py-2 rounded hover:bg-blue-100 transition">Back Home</a>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-blue-100 py-20 text-center">
    <h2 class="text-4xl font-bold text-blue-900 animate__animated animate__fadeInDown">Welcome to FinanceHubTracker</h2>
    <p class="text-gray-700 text-lg mt-4 max-w-2xl mx-auto">A real-time, efficient loan management system designed to transform how your business tracks, manages, and analyzes loan activities.</p>
    <a href="#trial" class="mt-8 inline-block bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition animate__animated animate__fadeInUp animate__delay-1s">Make Free Trial Now</a>
  </section>

  <!-- Features Section -->
  <section id="features" class="container mx-auto py-20 px-4">
    <h2 class="text-3xl text-center font-bold text-blue-900 mb-10">Core Features</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 text-center">
      <button onclick="showFeature('track')" class="bg-white p-6 rounded-lg shadow hover:bg-blue-50 transition">📊 Real-Time Tracking</button>
      <button onclick="showFeature('overdue')" class="bg-white p-6 rounded-lg shadow hover:bg-blue-50 transition">⏰ Overdue Alerts</button>
      <button onclick="showFeature('analytics')" class="bg-white p-6 rounded-lg shadow hover:bg-blue-50 transition">📈 Performance Analytics</button>
    </div>

    <!-- Feature Details -->
    <div class="mt-10">
      <div id="feature-track" class="feature-box bg-white p-6 rounded-lg shadow text-center">
        <h3 class="text-xl font-semibold text-blue-800">📊 Real-Time Tracking</h3>
        <p class="text-gray-600 mt-2">Monitor and manage all loan interactions instantly as they occur. Ensure full transparency in daily office operations.</p>
      </div>
      <div id="feature-overdue" class="feature-box bg-white p-6 rounded-lg shadow text-center">
        <h3 class="text-xl font-semibold text-blue-800">⏰ Overdue Alerts</h3>
        <p class="text-gray-600 mt-2">Automatically alert clients and staff of overdue payments. Schedule follow-ups with built-in fine and penalty management.</p>
      </div>
      <div id="feature-analytics" class="feature-box bg-white p-6 rounded-lg shadow text-center">
        <h3 class="text-xl font-semibold text-blue-800">📈 Business Performance</h3>
        <p class="text-gray-600 mt-2">View reports and performance dashboards in real-time to make smarter business decisions and optimize operations.</p>
      </div>
    </div>
  </section>

  <!-- Benefits Section -->
  <section id="benefits" class="bg-blue-50 py-20 px-4">
    <div class="container mx-auto text-center">
      <h2 class="text-3xl font-bold text-blue-900 mb-8">Why Choose FinanceHubTracker?</h2>
      <ul class="text-gray-700 text-lg space-y-4 max-w-3xl mx-auto">
        <li class="animate__animated animate__fadeInUp">✅ Automate daily transactions & reduce manual errors</li>
        <li class="animate__animated animate__fadeInUp animate__delay-1s">✅ Real-time monitoring and status updates</li>
        <li class="animate__animated animate__fadeInUp animate__delay-2s">✅ Comprehensive reports and business insights</li>
      </ul>
    </div>
  </section>

  <!-- Free Trial Section -->
  <section id="trial" class="py-20 text-center bg-white px-4">
    <h2 class="text-3xl font-bold text-blue-900">Try FinanceHubTracker Free</h2>
    <p class="text-gray-600 mt-4 mb-6">Start your  free  trials today and experience smart loan management.</p>
    <a href="{{ route('login') }}" class="inline-block bg-blue-700 text-white px-6 py-3 rounded-full hover:bg-blue-800 transition">Start Now</a>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-900 text-white py-6 text-center">
    <p>&copy; 2025 FinanceHubTracker. All rights reserved.</p>
  </footer>

  <!-- Feature Toggle Script -->
  <script>
    function showFeature(id) {
      const features = ['track', 'overdue', 'analytics'];
      features.forEach(feature => {
        const el = document.getElementById(`feature-${feature}`);
        if (feature === id) {
          el.classList.remove('visible', 'animate__animated', 'animate__bounceIn');
          el.style.display = 'block';
          void el.offsetWidth; // Reset animation
          el.classList.add('visible', 'animate__animated', 'animate__bounceIn');
        } else {
          el.classList.remove('visible');
          el.style.display = 'none';
        }
      });
    }
  </script>

</body>

</html>
