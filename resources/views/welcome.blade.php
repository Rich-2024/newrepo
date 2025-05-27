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
  <div class="min-h-screen backdrop-blur-[2px] bg-black/20 !mt-0">
    <!-- Navigation -->

  <nav class="bg-white/90 backdrop-blur-sm fixed w-full z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-0 !mt-0">
    <div class="flex justify-between h-16 items-center">
      <span class="text-2xl font-bold text-blue-600">FinanceHubTracker</span>
      <div class="hidden md:flex items-center space-x-6">
        <a href="#" class="text-gray-700 hover:text-blue-600">Home</a>
        <a href="#" class="text-gray-700 hover:text-blue-600">Services</a>
        <a href="#" class="text-gray-700 hover:text-blue-600">About</a>
        <a href="#" class="text-gray-700 hover:text-blue-600">Contact</a>
        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
          Sign In
        </a>
      </div>
    </div>
  </div>
</nav>

        @include('partials.success');

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4">
      <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 animate-fade-in">
          Financial Solutions for Your Future
        </h1>
        <p class="text-lg md:text-xl text-white/90 mb-12 max-w-3xl mx-auto">
          Unlock your financial potential with our comprehensive loan Tracker solutions. We provide personalized financial tailored system to your needs and accessible online Everywhere you go .
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
          <<a href="{{ route('login') }}" class="bg-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transition duration-200">
            Get Started
          </a>
          <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
          <<a href="{{ route('learn') }}" class="bg-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transition duration-200">
            Learn more
          </a>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white/80 py-16 px-4">
      <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
        <div>
          <p class="text-4xl font-bold text-blue-600">Ugx 10,0000,000+</p>
          <p class="text-gray-600 mt-2">Loans Funds are managed Efficiently</p>
        </div>
        <div>
          <p class="text-4xl font-bold text-blue-600">10K+</p>
          <p class="text-gray-600 mt-2">Happy Clients</p>
        </div>
        <div>
          <p class="text-4xl font-bold text-blue-600">98%</p>
          <p class="text-gray-600 mt-2">Success Rate</p>
        </div>
        <div>
          <p class="text-4xl font-bold text-blue-600">24/7</p>
          <p class="text-gray-600 mt-2">System Support/Working Rate</p>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="bg-white/95 py-24 px-4">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900">Our Financial Solutions Tracking Syatem</h2>
          <p class="mt-4 text-lg text-gray-600">Choose from our range of tailored financial Loan Tracker</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
          <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-200">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Personal Loans</h3>
            <p class="text-gray-600 mb-4">Flexible personal loans with competitive interest rates and easy repayment options.</p>
            <ul class="space-y-2 text-gray-600">
              <li>✓ Quick approval process</li>
                  <li>✓ Quick Loan process Tracking</li>

              <li>✓ Competitive rates from 5.99%</li>
              <li>✓ Flexible terms up to 7 years</li>
            </ul>
          </div>
          <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-200">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Business Loan system</h3>
            <p class="text-gray-600 mb-4">Empower your business growth with our tailored business financing solutions.</p>
            <ul class="space-y-2 text-gray-600">
              <li>✓ Up to $5M in funding</li>
                <li>✓ We rate your growth process</li>

              <li>✓ Equipment financing</li>
              <li>✓ Line of credit options</li>
            </ul>
          </div>
          <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition duration-200">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Home Loans</h3>
            <p class="text-gray-600 mb-4">Make your dream home a reality with our competitive mortgage options.</p>
            <ul class="space-y-2 text-gray-600">
              <li>✓ Low down payment options</li>
              <li>✓ Fixed & variable rates</li>
              <li>✓ First-time buyer programs</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="bg-gray-50/95 py-24 px-4">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900">What Our Clients Say</h2>
          <p class="mt-4 text-lg text-gray-600">Real feedback from our loan management users</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white p-8 rounded-xl shadow-md">
            <p class="text-gray-600 italic mb-4">"The loan tracking dashboard saved us countless hours. We can now monitor overdue payments in real-time."</p>
            <div class="flex items-center">
              <div class="ml-3">
                <p class="text-gray-900 font-semibold">Amit Shah</p>
                <p class="text-gray-500">Finance Manager, MicroLend</p>
              </div>
            </div>
          </div>
          <div class="bg-white p-8 rounded-xl shadow-md">
            <p class="text-gray-600 italic mb-4">"Easy to integrate and even easier to use. Our whole lending team adopted it within a week."</p>
            <div class="flex items-center">
              <div class="ml-3">
                <p class="text-gray-900 font-semibold">Linda Gomez</p>
                <p class="text-gray-500">Loan Officer, SwiftFunds</p>
              </div>
            </div>
          </div>
          <div class="bg-white p-8 rounded-xl shadow-md">
            <p class="text-gray-600 italic mb-4">"Customer reminders, EMI tracking, and repayment reports — all automated. Brilliant system!"</p>
            <div class="flex items-center">
              <div class="ml-3">
                <p class="text-gray-900 font-semibold">James Oduro</p>
                <p class="text-gray-500">CEO, AccraCredit</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="bg-white/95 py-24 px-4">
      <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div>
             <h2 class="text-3xl font-bold text-gray-900 mb-6">Ready to Get Started with Us?</h2> 
      <p class="text-lg text-gray-600 mb-8">
        Speak with our one of our technical teams today and take the first step toward loan management tailored to your needs.
      </p> 
          <div class="space-y-4">
            <div class="flex items-center">
              <span class="text-blue-600 mr-3">📞</span>
              <span class="text-gray-600">0775773225</span>
            </div>
            <div class="flex items-center">
              <span class="text-blue-600 mr-3">✉️</span>
              <span class="text-gray-600">ogwalrichie5@gmail.com</span>
            </div>
            <div class="flex items-center">
              <span class="text-blue-600 mr-3">📍</span>
              <span class="text-gray-600">123 Kampala city, Uganda</span>
            </div>
          </div>
        </div>
          <!-- Developer Image -->
      <div class="flex items-center space-x-4">
<img src="{{ asset('images/fuu.jpg') }}" alt="Lead Developer" class="w-24 h-24 rounded-full object-cover shadow-md">
        <div>
          <p class="text-gray-900 font-semibold text-lg">Mr:Ogwal Richard Richie</p>
          <p class="text-gray-600 text-sm"> Developer, FinanceHub</p>
        </div>
      </div>
    </div>
        <div class="bg-white p-8 rounded-xl shadow-lg">
          <h3 style="text-align: center"><strong>Inquire or send us your reviews
            </strong></h3>
          <form class="space-y-6">
            <input type="text" placeholder="Your Name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            <input type="email" placeholder="Email Address" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            <select class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent">
              <option>Select Loan Type</option>
              <option>Personal Loan</option>
              <option>Business Loan</option>
              <option>Home Loan</option>
            </select>
            <textarea placeholder="Your Message" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent"></textarea>
            <button class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
              Send Message
            </button>
          </form>
        </div>
      </div>
    </section>

  </div>
  <script type="module" src="/src/main.js"></script>
</body>
</html>
