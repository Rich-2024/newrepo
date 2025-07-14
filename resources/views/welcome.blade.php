<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Financial Solutions</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes slide-background {
      0% { background-position: 0% center; }
      100% { background-position: 100% center; }
    }
    @keyframes fade-in {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-background {
      animation: slide-background 30s linear infinite;
      background-size: 200% auto;
    }
    .animate-fade-in {
      animation: fade-in 1s ease-out;
    }
  </style>
</head>
<body class="min-h-screen bg-[url('https://images.pexels.com/photos/534216/pexels-photo-534216.jpeg')] bg-cover bg-center bg-no-repeat animate-slide-background">
  <div class="min-h-screen backdrop-blur-[2px] bg-black/20">

    <!-- Navigation -->
    <nav class="bg-white/90 backdrop-blur-sm fixed w-full z-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <span class="text-xl sm:text-2xl font-bold text-blue-600">FinanceHubTracker</span>
        @if(session('success'))
    <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div id="flash-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<script>
    // Auto-hide flash message after 3 seconds (3000 ms)
    setTimeout(() => {
        const flash = document.getElementById('flash-message');
        if (flash) {
            // fade out effect (optional)
            flash.style.transition = 'opacity 0.5s ease';
            flash.style.opacity = '0';

            // after fade out, remove from DOM
            setTimeout(() => flash.remove(), 500);
        }
    }, 3000);
</script>

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

          <!-- Hamburger -->
          <button id="nav-toggle" class="md:hidden text-gray-700 mr-4 focus:outline-none" aria-label="Toggle menu" aria-expanded="false">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <!-- Desktop Links -->
          <div class="hidden md:flex items-center space-x-6">
            <a href="/" class="text-gray-700 hover:text-blue-600 text-sm md:text-base lg:text-lg">Home</a>
            <a href="{{ route('service') }}" class="text-gray-700 hover:text-blue-600 text-sm md:text-base lg:text-lg">Services</a>
            <a href="{{ route('price') }}" class="text-gray-700 hover:text-blue-600 text-sm md:text-base lg:text-lg">Our Pricing</a>
            <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 text-sm md:text-base lg:text-lg">Contact</a>
            <a href="{{ route('learn') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 text-sm md:text-base lg:text-lg">Learn more</a>
          </div>
        </div>
        <!-- Mobile Menu -->
        <div id="nav-menu" class="hidden absolute bg-white w-full left-0 top-full p-6 shadow-md md:hidden flex flex-col space-y-4 z-50">
          <a href="/" class="text-gray-700 hover:text-blue-600 text-base">Home</a>
          <a href="{{ route('service') }}" class="text-gray-700 hover:text-blue-600 text-base">Services</a>
          <a href="{{ route('price') }}" class="text-gray-700 hover:text-blue-600 text-base">Our Pricing</a>
          <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 text-base">Contact</a>
          <a href="{{ route('learn') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 text-base mt-4">Learn more</a>
        </div>
      </div>
    </nav>

    @include('partials.success');

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4">
      <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-6 animate-fade-in">Financial Solutions for Your Future</h1>
        <p class="text-sm sm:text-base md:text-lg text-white/90 mb-12 max-w-3xl mx-auto">Unlock your financial potential with our comprehensive loan Tracker solutions. We provide personalized financial tailored system to your needs and accessible online everywhere you go.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
          <a href="{{ route('terms') }}" class="bg-blue-600 text-white px-8 py-4 rounded-lg text-base sm:text-lg font-semibold hover:bg-blue-700 transition duration-200">Get Started</a>
          <a href="{{ route('login') }}" class="bg-blue-600 text-white px-8 py-4 rounded-lg text-base sm:text-lg font-semibold hover:bg-blue-700 transition duration-200">Login</a>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white/80 py-16 px-4">
      <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
        <div><p class="text-3xl sm:text-4xl md:text-5xl font-bold text-blue-600">Ugx 10,0000,000+</p><p class="text-xs sm:text-sm md:text-base text-gray-600 mt-2">Loans funds are managed efficiently</p></div>
        <div><p class="text-3xl sm:text-4xl md:text-5xl font-bold text-blue-600">10K+</p><p class="text-xs sm:text-sm md:text-base text-gray-600 mt-2">Happy Clients</p></div>
        <div><p class="text-3xl sm:text-4xl md:text-5xl font-bold text-blue-600">98%</p><p class="text-xs sm:text-sm md:text-base text-gray-600 mt-2">Success Rate</p></div>
        <div><p class="text-3xl sm:text-4xl md:text-5xl font-bold text-blue-600">24/7</p><p class="text-xs sm:text-sm md:text-base text-gray-600 mt-2">Support &amp; Working Rate</p></div>
      </div>
    </section>

    <!-- Features Section -->
   <section class="bg-white/95 py-24 px-4">
  <div class="max-w-7xl mx-auto text-center mb-16">
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">Our Financial Solutions Tracking System</h2>
    <p class="mt-4 text-sm sm:text-base md:text-lg text-gray-600">
      Choose from our range of tailored financial Loan Tracker tools designed for visibility, control, and growth.
    </p>
  </div>

  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 px-4">

    <!-- Card 1: Loan Status Tracker -->
    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-200">
      <div class="mb-4">
        <img src="https://img.icons8.com/color/96/graph-report.png" alt="Loan Status" class="w-14 h-14">
      </div>
      <h3 class="text-xl font-semibold text-gray-800 mb-2">Loan Status Tracker</h3>
      <p class="text-gray-600 text-sm">
        Instantly view the lifecycle of every loan — from application to disbursement and repayment. Stay on top of every client’s progress.
      </p>
    </div>

    <!-- Card 2: Repayment Monitoring -->
    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-200">
      <div class="mb-4">
        <img src="https://images.pexels.com/photos/47344/dollar-currency-money-us-dollar-47344.jpeg" alt="Repayment Monitoring" class="w-14 h-14">
      </div>
      <h3 class="text-xl font-semibold text-gray-800 mb-2">Repayment Monitoring</h3>
      <p class="text-gray-600 text-sm">
        Track due dates, receive alerts for missed payments, and automate reminders to clients — ensuring your collections are always on point.
      </p>
    </div>

    <!-- Card 3: Real-Time Analytics -->
    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-200">
      <div class="mb-4">
        <img src="https://img.icons8.com/color/96/combo-chart--v1.png" alt="Analytics" class="w-14 h-14">
      </div>
      <h3 class="text-xl font-semibold text-gray-800 mb-2">Real-Time Analytics</h3>
      <p class="text-gray-600 text-sm">
        Access powerful dashboards that show loan performance, risk exposure, branch metrics, and financial health — all updated in real time.
      </p>
    </div>

  </div>
</section>


   <!-- Testimonials Section -->
<section class="bg-gray-50/95 py-24 px-4">
  <div class="max-w-7xl mx-auto text-center mb-16">
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">What Our Clients Say</h2>
    <p class="mt-4 text-sm sm:text-base md:text-lg text-gray-600">Real feedback from our loan management users</p>
  </div>
  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-4">

    <!-- Testimonial 1 -->
    <div class="bg-white rounded-lg shadow p-6 text-left">
      <img class="rounded-md mb-4 w-full h-40 object-cover" src="https://images.pexels.com/photos/4475523/pexels-photo-4475523.jpeg" alt="African woman using laptop">
      <p class="text-gray-700 italic">"Managing client loans used to be a nightmare. With this system, we track repayments easily and stay compliant."</p>
      <div class="mt-6 flex items-center">
        <img class="w-12 h-12 rounded-full mr-4" src="https://images.pexels.com/photos/31485662/pexels-photo-31485662.jpeg" alt="Amina K.">
        <div>
          <p class="text-sm font-semibold text-gray-900">Amina K.</p>
          <p class="text-xs text-gray-500">Loan Manager, Uganda Microfinance</p>
        </div>
      </div>
    </div>

    <!-- Testimonial 2 -->
    <div class="bg-white rounded-lg shadow p-6 text-left">
      <img class="rounded-md mb-4 w-full h-40 object-cover" src="https://images.pexels.com/photos/7948060/pexels-photo-7948060.jpeg" alt="African man in office">
      <p class="text-gray-700 italic">"This tool gave us full visibility into loan performance. It's easy to use and fits our workflows perfectly."</p>
      <div class="mt-6 flex items-center">
        <img class="w-12 h-12 rounded-full mr-4" src="https://randomuser.me/api/portraits/men/77.jpg" alt="Samuel T.">
        <div>
          <p class="text-sm font-semibold text-gray-900">Samuel T.</p>
          <p class="text-xs text-gray-500">Finance Director, kampala Credit Union</p>
        </div>
      </div>
    </div>

    <!-- Testimonial 3 -->
    <div class="bg-white rounded-lg shadow p-6 text-left">
      <img class="rounded-md mb-4 w-full h-40 object-cover" src="https://images.pexels.com/photos/7191994/pexels-photo-7191994.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="African woman in a meeting">
      <p class="text-gray-700 italic">"From approval to disbursement and monitoring — everything is streamlined. This system gave us control."</p>
      <div class="mt-6 flex items-center">
        <img class="w-12 h-12 rounded-full mr-4" src="https://randomuser.me/api/portraits/women/83.jpg" alt="Ngozi E.">
        <div>
          <p class="text-sm font-semibold text-gray-900">Ngozi E.</p>
          <p class="text-xs text-gray-500">Branch Officer, Lagos Lending Hub</p>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Admin Dashboard Section -->
<section class="bg-gray-100 py-24 px-4">
  <div class="max-w-7xl mx-auto text-center mb-16">
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">Admin Dashboard</h2>
    <p class="mt-4 text-sm sm:text-base md:text-lg text-gray-600">
      Powerful tools to manage loans, monitor performance, and stay compliant — all in one place.
    </p>
  </div>

  <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-12">
    <!-- Screenshot or illustration -->
    <img src="https://images.pexels.com/photos/5816307/pexels-photo-5816307.jpeg" alt="Admin Dashboard" class="w-full md:w-1/2 rounded-lg shadow-md object-cover">

    <!-- Features -->
    <div class="w-full md:w-1/2 space-y-6 text-left">
      <div>
        <h3 class="text-lg font-semibold text-gray-800">🎯 Centralized Loan Management</h3>
        <p class="text-gray-600 text-sm">Track all loans, repayments, and customer statuses in real time.</p>
      </div>
      <div>
        <h3 class="text-lg font-semibold text-gray-800">📊 Real-Time Reports</h3>
        <p class="text-gray-600 text-sm">Generate performance, compliance, and audit reports with a click.</p>
      </div>
      <div>
        <h3 class="text-lg font-semibold text-gray-800">🛡️ Role-Based Access</h3>
        <p class="text-gray-600 text-sm">Secure access for staff with different permission levels (Admin, Officer, Auditor).</p>
      </div>
      <div>
        <h3 class="text-lg font-semibold text-gray-800">🔔 Automated Notifications</h3>
        <p class="text-gray-600 text-sm">Get alerts on overdue payments, new applications, or suspicious activity.</p>
      </div>
    </div>
  </div>
</section>

    <!-- Contact Section -->
    <section class="bg-white/95 py-24 px-4">
      <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center px-4">
        <div>
          <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-6">Ready to Get Started with Us?</h2>
          <p class="text-sm sm:text-base md:text-lg text-gray-600 mb-8">Speak with our technical team today and take the first step toward loan management tailored to your needs.</p>
          <div class="space-y-4">
            <div class="flex items-center"><span class="text-blue-600 mr-3">📞</span><span class="text-gray-600">0775773225</span></div>
            <div class="flex items-center"><span class="text-blue-600 mr-3">✉️</span><span class="text-gray-600">ogwalrichie5@gmail.com</span></div>
            <div class="flex items-center"><span class="text-blue-600 mr-3">📍</span><span class="text-gray-600">123 Kampala city, Uganda</span></div>
          </div>
          <div class="flex items-center space-x-4 mt-6">
            <img src="{{ asset('images/fuu.jpg') }}" alt="Lead Developer" class="w-24 h-24 rounded-full object-cover shadow-md">
            <div><p class="text-base sm:text-lg font-semibold text-gray-900">Mr. Ogwal Richard Richie</p><p class="text-xs sm:text-sm text-gray-600">Technical personnel, FinanceHub</p></div>
          </div>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-lg">
          <h3 class="text-lg sm:text-xl font-bold text-center mb-4">Inquire or send us your reviews</h3>
          @if(session('success'))<div class="mb-4 text-green-600">{{ session('success') }}</div>@endif
          @if($errors->any())<div class="mb-4 text-red-600"><ul>@foreach($errors->all() as $error)<li>- {{ $error }}</li>@endforeach</ul></div>@endif
          <form method="POST" action="{{ route('loan.inquiry.submit') }}" class="space-y-6">
            @csrf
            <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-lg border border-gray-300 text-sm sm:text-base focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-lg border border-gray-300 text-sm sm:text-base focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            <select name="loan_type" required class="w-full px-4 py-3 rounded-lg border border-gray-300 text-sm sm:text-base focus:ring-2 focus:ring-blue-600 focus:border-transparent">
              <option value="">Select Loan Type</option>
              <option value="Personal Loan" {{ old('loan_type')=='Personal Loan'?'selected':'' }}>Personal Loan</option>
              <option value="Business Loan" {{ old('loan_type')=='Business Loan'?'selected':'' }}>Business Loan</option>
              <option value="Home Loan" {{ old('loan_type')=='Home Loan'?'selected':'' }}>Home Loan</option>
            </select>
            <textarea name="message" rows="4" placeholder="Your Message" required class="w-full px-4 py-3 rounded-lg border border-gray-300 text-sm sm:text-base focus:ring-2 focus:ring-blue-600 focus:border-transparent">{{ old('message') }}</textarea>
            <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold text-base sm:text-lg hover:bg-blue-700 transition duration-200">Send Message</button>
          </form>
        </div>
      </div>
    </section>

  </div>

  <script>
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');
    navToggle.addEventListener('click', () => {
      navMenu.classList.toggle('hidden');
      navToggle.setAttribute('aria-expanded', !navMenu.classList.contains('hidden'));
    });
    document.addEventListener('click', (e) => {
      if (!navMenu.contains(e.target) && !navToggle.contains(e.target) && !navMenu.classList.contains('hidden')) {
        navMenu.classList.add('hidden');
        navToggle.setAttribute('aria-expanded', 'false');
      }
    });
  </script>
  @include('footer')
</body>
</html>
