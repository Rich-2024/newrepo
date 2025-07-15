<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Loan Management System</title>

  <!-- ✅ Favicon -->
<link rel="icon" type="image/png" href="{{ url('images/loan.png') }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#4F46E5"
          }
        }
      }
    };
  </script>
</head>

<body class="bg-gray-100 font-sans antialiased">

  <!-- Topbar -->
  <header class="w-full bg-white shadow px-4 py-3 flex justify-between items-center md:px-6 fixed top-0 left-0 right-0 z-50">
    <!-- Hamburger for mobile -->
    <button id="menuButton" class="md:hidden text-gray-700 focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <div class="text-xl font-bold text-gray-700">Secure management</div>

    <!-- Admin Profile -->
    <div class="relative">
      <button id="profileButton" class="flex items-center focus:outline-none">
        <img src="{{ $user->profile_picture ?? 'https://i.pravatar.cc/150?img=3' }}" alt="Admin" class="w-10 h-10 rounded-full border-2 border-primary">
      </button>

      <!-- Dropdown -->
      <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50">
    <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100">Profile</a>
    <a href="{{ route('interest') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100">Settings</a>
    <div class="border-t my-1"></div>

    <!-- Logout Form -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="block w-full text-left px-4 py-2 text-red-500 hover:bg-red-100 hover:text-red-600">
            Logout
        </button>
    </form>
</div>

    </div>
  </header><!-- Bootstrap JS (includes Popper.js for Bootstrap components) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>






  <div class="flex min-h-screen relative">
    <!-- Sidebar -->
    <aside id="sidebar"
      class="fixed inset-y-0 left-0 w-64 bg-white shadow-md transform -translate-x-full md:translate-x-0 md:relative md:flex transition-transform duration-300 z-40">
      <nav class="mt-4 space-y-2 px-4">

        <!-- Admin System Label -->
        <div class="px-4 py-2 mb-4 mt-12 text-white text-center bg-blue-600 rounded-lg font-bold text-lg">
          Admin System
        </div>

        <!-- Dashboard Dropdown -->
        <div>
          <button id="dashboardDropdownButton" class="flex justify-between items-center w-full text-left px-4 py-2 text-gray-700 font-medium hover:bg-indigo-100 hover:text-indigo-600 transition duration-300 rounded-lg">
            Dashboard
            <svg class="w-4 h-4 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="dashboardDropdown" class="hidden space-y-2 px-4">

         <!-- Dashboard Overview -->
<a href="/dashboard/view"
   class="flex items-center gap-3 px-4 py-2 rounded-md transition-colors duration-200
   {{ request()->is('dashboard/view') ? 'bg-indigo-100 text-indigo-600 font-semibold' : 'text-gray-700 hover:bg-indigo-100 hover:text-indigo-600' }}">

    <svg class="w-5 h-5 {{ request()->is('dashboard/view') ? 'text-indigo-600' : 'text-indigo-500' }}"
         fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
    </svg>

    <span class="text-sm font-medium">Overview</span>
</a>


<!-- View Clients -->
<a href="{{ route('loans.clients.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <svg class="w-5 h-5 mr-2 text-cyan-600" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m1-1.13a4 4 0 100-8 4 4 0 000 8zm6 0a4 4 0 100-8 4 4 0 000 8z"/>
    </svg>
    View Clients
</a>

        </div>
        </div>

        <!-- Clients Dropdown (Action) -->
        <div>
          <button id="clientsDropdownButton" class="flex justify-between items-center w-full text-left px-4 py-2 text-gray-700 font-medium hover:bg-indigo-100 hover:text-indigo-600 transition duration-300 rounded-lg">
            Actions
            <svg class="w-4 h-4 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="clientsDropdown" class="hidden space-y-2 px-4">

<!-- Create Loan -->
<a href="{{ route('create') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
    Issue Loan
</a>

<!-- Repay Loan -->
<a href="/repayment" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M17 9V7a4 4 0 00-8 0v2m-2 4h12m-6 4v-4"/>
    </svg>
    Repay Loan
</a>

<!-- Manage Loans -->
<a href="{{ route('clients.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 7h18M3 12h18M3 17h18"/>
    </svg>
    Manage Loans
</a>

<!-- Settled Loans -->
<a href="{{ route('settled_loans.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M5 13l4 4L19 7"/>
    </svg>
    Settled Loans
</a>

<!-- View Fines -->
<a href="{{ route('fine_loans.table') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 8v4m0 4h.01M4.93 4.93a10 10 0 0114.14 0M4.93 19.07a10 10 0 0114.14 0"/>
    </svg>
    View Fines
</a>


        </div>
        </div>

        <!-- Loan History Dropdown -->
        <div>
          <button id="loanHistoryDropdownButton" class="flex justify-between items-center w-full text-left px-4 py-2 text-gray-700 font-medium hover:bg-indigo-100 hover:text-indigo-600 transition duration-300 rounded-lg">
            Loan History
            <svg class="w-4 h-4 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="loanHistoryDropdown" class="hidden space-y-2 px-4">
<a href="{{ route('reports.repayments') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <!-- Icon: Money / Transaction -->
    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 8c-1.657 0-3 1.567-3 3.5S10.343 15 12 15s3-1.567 3-3.5S13.657 8 12 8zM3 12a9 9 0 0118 0 9 9 0 01-18 0zm9-9v2m0 14v2" />
    </svg>
    Repayments
</a>
<a href="{{ route('reports.defaulters') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <!-- Icon: Alert / Exclamation -->
    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 9v3.75m0 3.75h.007M10.29 3.86L1.82 18a1.5 1.5 0 001.29 2.25h17.78a1.5 1.5 0 001.29-2.25L13.71 3.86a1.5 1.5 0 00-2.42 0z" />
    </svg>
    Defaulters
</a>
<a href="{{ route('settled') }}"
   class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 8c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3zm0 10.5c4.142 0 7.5-3.358 7.5-7.5S16.142 3.5 12 3.5 4.5 6.858 4.5 11s3.358 7.5 7.5 7.5z" />
    </svg>
    Overdue Repayments
</a>
<a href="{{ route('archived_settled_loans.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <!-- Icon: Archive Box -->
    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M5 8h14v11a1 1 0 01-1 1H6a1 1 0 01-1-1V8z" />
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M10 12h4" />
    </svg>
    Archives
</a>

          </div>
        </div>

        <!-- Reports Dropdown -->
        <div>
          <button id="reportsDropdownButton" class="flex justify-between items-center w-full text-left px-4 py-2 text-gray-700 font-medium hover:bg-indigo-100 hover:text-indigo-600 transition duration-300 rounded-lg">
            Reports
            <svg class="w-4 h-4 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="reportsDropdown" class="hidden space-y-2 px-4">
<a href="{{ route('reports.generate') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <!-- Icon: Chart Bar -->
    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 3v18h18M9 17V9m4 8v-4m4 4v-6" />
    </svg>
    Business Reports
</a>
<a href="{{ route('loan.report') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <!-- Icon: Magnifying Glass Chart -->
    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
    </svg>
    Analysis
</a>

<a href="{{ route('stat') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <!-- Icon: Chart Line -->
    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 3v18h18M4 16l5-6 4 5 7-10" />
    </svg>
    Statistic Rating
</a>
          </div>
        </div>

        <!-- Settings Dropdown -->
        <div>
          <button id="settingsDropdownButton" class="flex justify-between items-center w-full text-left px-4 py-2 text-gray-700 font-medium hover:bg-indigo-100 hover:text-indigo-600 transition duration-300 rounded-lg">
            Settings
            <svg class="w-4 h-4 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="settingsDropdown" class="hidden space-y-2 px-4">
<a href="{{ route('interest') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <!-- Icon (e.g., a calculator or currency icon) -->
    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 8c-1.657 0-3 1.567-3 3.5S10.343 15 12 15s3-1.567 3-3.5S13.657 8 12 8zm0 0V6m0 9v2.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>

    Interest Rate Settings
</a>
<a href="{{ route('loan_fines.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <!-- Icon (e.g., scale icon to represent fine/penalty) -->
    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 3v2m6.364 1.636l-1.414 1.414M21 12h-2M17.364 17.364l-1.414-1.414M12 21v-2M6.636 17.364l1.414-1.414M3 12h2M6.636 6.636l1.414 1.414M12 8a4 4 0 100 8 4 4 0 000-8z"/>
    </svg>
    Define Fine
</a>

<a href="{{ route('profile') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
    <!-- Icon: User Circle -->
    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M4.5 19.5a8.25 8.25 0 1115 0v.75a.75.75 0 01-.75.75h-13.5a.75.75 0 01-.75-.75V19.5z" />
    </svg>
    Admin Profile Setting
</a>
          </div>
        </div>

      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 mt-16 md:mt-0 w-full">
      @yield('content')
    </main>
  </div>

  <!-- Footer -->
  <footer class="bg-blue-800 text-white py-6 mt-8">
    <div class="container mx-auto text-center">
      <p>&copy; 2025 Loan Management System. All rights reserved.</p>
      <p>Created with ❤️ for Loan Management</p>
    </div>
  </footer>

  <!-- Overlay for mobile when sidebar is open -->
  <div id="overlay" class="fixed inset-0 bg-black opacity-30 hidden z-30 md:hidden"></div>

  <script>
    const menuButton = document.getElementById("menuButton");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    // Toggle sidebar on mobile
    menuButton.addEventListener("click", () => {
      sidebar.classList.remove("-translate-x-full");
      overlay.classList.remove("hidden");
    });

    // Close sidebar when clicking outside
    document.addEventListener("click", (e) => {
      if (!sidebar.contains(e.target) && !menuButton.contains(e.target)) {
        if (window.innerWidth < 768) {
          sidebar.classList.add("-translate-x-full");
          overlay.classList.add("hidden");
        }
      }
    });

    // Toggle dropdown visibility
    const dropdownButtons = [
      { buttonId: "dashboardDropdownButton", dropdownId: "dashboardDropdown" },
      { buttonId: "clientsDropdownButton", dropdownId: "clientsDropdown" },
      { buttonId: "loanHistoryDropdownButton", dropdownId: "loanHistoryDropdown" },
      { buttonId: "reportsDropdownButton", dropdownId: "reportsDropdown" },
      { buttonId: "settingsDropdownButton", dropdownId: "settingsDropdown" }
    ];

    dropdownButtons.forEach(item => {
      const button = document.getElementById(item.buttonId);
      const dropdown = document.getElementById(item.dropdownId);

      button.addEventListener("click", () => {
        dropdown.classList.toggle("hidden");
      });
    });

    // Profile dropdown toggle
    const profileButton = document.getElementById("profileButton");
    const dropdownMenu = document.getElementById("dropdownMenu");

    profileButton.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdownMenu.classList.toggle("hidden");
    });

    // Close profile dropdown when clicking outside
    document.addEventListener("click", (e) => {
      if (!dropdownMenu.contains(e.target) && !profileButton.contains(e.target)) {
        dropdownMenu.classList.add("hidden");
      }
    });
  </script>
</body>
</html>
