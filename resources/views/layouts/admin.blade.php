<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Loan Management System</title>
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
  <header class="w-full bg-white shadow px-4 py-3 flex justify-between items-center md:px-6">
    <!-- Hamburger for mobile -->
    <button id="menuButton" class="md:hidden text-gray-700 focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <div class="text-xl font-bold text-gray-700">Loan Admin</div>

    <!-- Admin Profile -->
    <div class="relative">
      <button id="profileButton" class="flex items-center focus:outline-none">
        <img src="https://i.pravatar.cc/40?img=3" alt="Admin" class="w-10 h-10 rounded-full border-2 border-primary">
      </button>

      <!-- Dropdown -->
      <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50">
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100">Profile</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100">Settings</a>
        <div class="border-t my-1"></div>
        <a href="#" class="block px-4 py-2 text-red-500 hover:bg-red-100 hover:text-red-600">Logout</a>
      </div>
    </div>
  </header>

  <div class="flex min-h-screen relative">
    <!-- Sidebar -->
    <aside id="sidebar"
      class="fixed inset-y-0 left-0 w-64 bg-white shadow-md transform -translate-x-full md:translate-x-0 md:relative md:flex transition-transform duration-300 z-40">
      <nav class="mt-4 space-y-2 px-4">
        
        <!-- Admin System Label -->
        <div class="px-4 py-2 mb-4 text-white text-center bg-blue-600 rounded-lg font-bold text-lg">
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
            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">Overview</a>
          </div>
        </div>

        <!-- Clients Dropdown (Action) -->
        <div>
          <button id="clientsDropdownButton" class="flex justify-between items-center w-full text-left px-4 py-2 text-gray-700 font-medium hover:bg-indigo-100 hover:text-indigo-600 transition duration-300 rounded-lg">
            Clients
            <svg class="w-4 h-4 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="clientsDropdown" class="hidden space-y-2 px-4">
            <a href="{{ route('client') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">Action</a>
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
            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">Repayments</a>
            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">Defaulters</a>
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
            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">Monthly Reports</a>
            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">Yearly Reports</a>
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
            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">General Settings</a>
            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition">User Management</a>
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
  <footer class="bg-gray-800 text-white py-6 mt-8">
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
