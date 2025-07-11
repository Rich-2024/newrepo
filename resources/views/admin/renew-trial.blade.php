<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Renew Trial - Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

  <!-- Header -->
 <!-- Header -->
<header class="bg-blue-900 text-white p-5 shadow-md sticky top-0 z-50">
  <div class="container mx-auto flex justify-between items-center">
    <h1 class="text-2xl font-bold">Admin Panel</h1>

    <!-- Logout Button -->
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
        Logout
      </button>
    </form>
  </div>
</header>


  <!-- Main Content -->
  <div class="container mx-auto py-12 px-6">

    <!-- Display success or error messages -->
@include('partials.success')

    <!-- User Table (Showing users and their trial details) -->
    <div class="overflow-x-auto mb-8">
      <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
        <thead>
          <tr class="bg-blue-900 text-white">
            <th class="p-3 text-left">User Name</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">Trial Start Date</th>
            <th class="p-3 text-left">Trial End Date</th>
            <th class="p-3 text-left">Status</th>
            <th class="p-3 text-left">Duration</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
            <tr class="border-b hover:bg-gray-100">
              <td class="p-3">{{ $user->name }}</td>
              <td class="p-3">{{ $user->email }}</td>
              <td class="p-3">{{ $user->trial_start_date }}</td>
              <td class="p-3">{{ $user->trial_end_date }}</td>
              <td class="p-3">{{ $user->is_trial_active ? 'Active' : 'Expired' }}</td>
              <td class="p-3">{{ $user->trial_duration_months }} Months</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Form to renew trial -->
    <form action="{{ route('admin.renew-trial.store') }}" method="POST">
      @csrf
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
        <h2 class="text-xl font-bold mb-6">Renew Trial Access</h2>

        <!-- Select User -->
        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700">Select User</label>
            <select name="user_id" id="user_id" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                <option value="">-- Select a User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Months to extend -->
        <div class="mb-4">
            <label for="months" class="block text-sm font-medium text-gray-700">Months to extend</label>
            <input type="number" name="months" id="months" class="mt-1 block w-full p-2 border border-gray-300 rounded" placeholder="Enter number of months" required min="1">
            @error('months')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Renew Trial</button>
      </div>
    </form>
  </div>

  <!-- Footer -->
  <footer class="bg-blue-900 text-white py-6 text-center">
    <p>&copy; 2025 FinanceHubTracker. All rights reserved.</p>
  </footer>

</body>

</html>
