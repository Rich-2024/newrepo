<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FinanceHubTracker - Contact Us</title>
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
        <a href="{{ route('service') }}" class="hover:text-blue-300">Services</a>
        <a href="/contact" class="hover:text-blue-300 font-semibold underline">Contact</a>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-blue-100 py-20 text-center">
    <h2 class="text-4xl font-bold text-blue-900 animate__animated animate__fadeInDown">Let’s Talk Business</h2>
    <p class="text-gray-700 text-lg mt-4 max-w-2xl mx-auto">Looking for a tailored loan management solution or something else? We’re here to help. Reach out today and let’s build something perfect for your business.</p>
  </section>

  <!-- Contact Details -->
  <section class="py-20 px-4">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

      <!-- Info -->
      <div class="space-y-6 text-blue-900">
        <h3 class="text-2xl font-bold mb-4">📞 Reach Out Directly</h3>
        <p class="flex items-center text-lg"><span class="text-2xl mr-3">📞</span> <strong>Phone:</strong> 0775773225</p>
        <p class="flex items-center text-lg"><span class="text-2xl mr-3">✉️</span> <strong>Email:</strong> ogwalrichie5@gmail.com</p>
        <p class="flex items-center text-lg"><span class="text-2xl mr-3">📍</span> <strong>Location:</strong> 123 Kampala City, Uganda</p>
      </div>

      <!-- Optional Form -->
      <div class="bg-white p-8 rounded-lg shadow-md animate__animated animate__fadeInUp">
        <h3 class="text-xl font-semibold text-blue-800 mb-4">📬 Send Us a Message</h3>
        <form action="#" method="POST" class="space-y-4">
          <input type="text" name="name" placeholder="Your Name" class="w-full border border-gray-300 p-3 rounded" required />
          <input type="email" name="email" placeholder="Your Email" class="w-full border border-gray-300 p-3 rounded" required />
          <textarea name="message" rows="5" placeholder="Tell us about your business needs..." class="w-full border border-gray-300 p-3 rounded" required></textarea>
          <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800 transition">Send Message</button>
        </form>
      </div>

    </div>
  </section>

  <!-- Call to Action -->
  <section class="bg-blue-900 text-white py-12 text-center">
    <h2 class="text-2xl font-semibold mb-4">Prefer to talk directly?</h2>
    <p class="text-lg">Call us now: <strong class="text-yellow-300">0775773225</strong></p>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-900 text-white py-6 text-center">
    <p>&copy; 2025 FinanceHubTracker. All rights reserved.</p>
  </footer>

</body>

</html>
