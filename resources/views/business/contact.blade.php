<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FinanceHubTracker - Contact Us</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="bg-gray-50 font-sans">

  <!-- Header -->
  <header class="bg-blue-900 text-white p-5 sticky top-0 z-50 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-bold">FinanceHubTracker</h1>

      <!-- Mobile Toggle -->
      <button id="menu-toggle" class="md:hidden focus:outline-none text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>

      <!-- Nav Menu -->
      <nav id="mobile-menu"
        class="hidden absolute top-full left-0 w-full bg-blue-900 md:flex md:static md:w-auto md:space-x-6 md:items-center md:bg-transparent">
        <a href="/" class="block px-4 py-2 hover:text-blue-300">Home</a>
        <a href="{{ route('price') }}" class="block px-4 py-2 hover:text-blue-300">Pricing</a>
        <a href="{{ route('service') }}" class="block px-4 py-2 hover:text-blue-300">Services</a>
        <a href="/contact" class="block px-4 py-2 text-blue-300 font-semibold underline">Contact</a>
      </nav>
    </div>
  </header>

  <!-- Hero -->
  <section class="bg-blue-100 py-20 text-center px-4">
    <h2 class="text-4xl font-bold text-blue-900 animate__animated animate__fadeInDown">Let’s Talk Business</h2>
    <p class="text-gray-700 text-lg mt-4 max-w-2xl mx-auto">
      Looking for a tailored loan management solution or something else? We’re here to help.
      Reach out today and let’s build something perfect for your business.
    </p>
  </section>

  <!-- Contact Info & Form -->
  <section class="py-20 px-4">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

      <!-- Contact Info -->
      <div class="space-y-6 text-blue-900">
        <h3 class="text-2xl font-bold mb-4 flex items-center">
          <svg class="w-6 h-6 mr-2 text-blue-700" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 5h2a2 2 0 012 2v2a2 2 0 01-2 2H3v6a2 2 0 002 2h2a2 2 0 002-2v-6a2 2 0 00-2-2H3z" />
          </svg>
          Reach Out Directly
        </h3>

        <p class="flex items-center text-lg">
          <svg class="w-6 h-6 mr-3 text-blue-700" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 5h2l3 7-1.5 1.5L3 6v-1z" />
          </svg>
          <strong>Phone:</strong> 0775773225
        </p>

        <p class="flex items-center text-lg">
          <svg class="w-6 h-6 mr-3 text-blue-700" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M16 12H8m0 0l4-4m-4 4l4 4" />
          </svg>
          <strong>Email:</strong> ogwalrichie5@gmail.com
        </p>

        <p class="flex items-center text-lg">
          <svg class="w-6 h-6 mr-3 text-blue-700" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 2C8.13 2 5 5.13 5 9c0 4.92 7 13 7 13s7-8.08 7-13c0-3.87-3.13-7-7-7z" />
            <circle cx="12" cy="9" r="2.5" fill="currentColor" />
          </svg>
          <strong>Location:</strong> 123 Kampala City, Uganda
        </p>
      </div>

      <!-- Contact Form -->
      <div class="bg-white p-8 rounded-lg shadow-md animate__animated animate__fadeInUp">
        <h3 class="text-xl font-semibold text-blue-800 mb-4">📬 Send Us a Message</h3>
        <form action="#" method="POST" class="space-y-4">
          <input type="text" name="name" placeholder="Your Name" class="w-full border border-gray-300 p-3 rounded"
            required />
          <input type="email" name="email" placeholder="Your Email"
            class="w-full border border-gray-300 p-3 rounded" required />
          <textarea name="message" rows="5" placeholder="Tell us about your business needs..."
            class="w-full border border-gray-300 p-3 rounded" required></textarea>
          <button type="submit"
            class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800 transition">Send
            Message</button>
        </form>
      </div>

    </div>
  </section>

  <!-- Call to Action -->
  <section class="bg-blue-900 text-white py-12 text-center px-4">
    <h2 class="text-2xl font-semibold mb-4">Prefer to talk directly?</h2>
    <p class="text-lg">Call us now: <strong class="text-yellow-300">0775773225</strong></p>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-900 text-white py-6 text-center">
    <p>&copy; 2025 FinanceHubTracker. All rights reserved.</p>
  </footer>

  <!-- Hamburger Toggle Script -->
  <script>
    const toggleBtn = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      mobileMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
      if (!mobileMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
        mobileMenu.classList.add('hidden');
      }
    });

    const navLinks = mobileMenu.querySelectorAll('a');
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
      });
    });
  </script>

</body>

</html>
