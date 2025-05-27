@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 mt-0">    <!-- Profile Settings Header -->
    <div class="text-center mt-0 mb-8 mt-0">
        <h2 class="text-3xl font-semibold text-gray-800 px-4 sm:px-0 mt-5">Profile Settings</h2> <!-- Added padding -->
        <p class="text-gray-600">Update your personal details and account settings.</p>
    </div>

    <!-- Profile Form -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
      <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">

          <!-- Profile Picture Section -->
          <div class="flex justify-center">
            <div class="relative">
              <!-- Display existing profile picture or default image -->
              <img src="{{ auth()->user()->profile_picture ?? 'https://i.pravatar.cc/150?img=3' }}" alt="Profile Picture" class="w-32 h-32 rounded-full border-4 border-blue-500 object-cover">
              
              <button type="button" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 5L3 12l13 7V5z" />
                </svg>
              </button>
            </div>
          </div>
          
          <!-- File Input for Profile Picture -->
          <div class="text-center mt-2">
            <label for="profile_picture" class="text-blue-600 cursor-pointer">Change Picture</label>
            <input type="file" name="profile_picture" id="profile_picture" class="hidden mt-2" accept="image/*" />
          </div>

          <!-- Personal Information Section -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="name" class="text-gray-700">Full Name</label>
              <input type="text" id="name" name="name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" value="" required />
            </div>
            <div>
              <label for="email" class="text-gray-700">Email Address</label>
              <input type="email" id="email" name="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" value="" required />

              {{-- <input type="email" id="email" name="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('email', auth()->user()->email) }}" required /> --}}
            </div>
          </div>

          <!-- Security Settings Section -->
          <div>
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Security Settings</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label for="current_password" class="text-gray-700">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="••••••••" />
              </div>
              <div>
                <label for="new_password" class="text-gray-700">New Password</label>
                <input type="password" id="new_password" name="new_password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="••••••••" />
              </div>
              <div>
                <label for="confirm_password" class="text-gray-700">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="••••••••" />
              </div>
            </div>
          </div>

          <!-- Save Changes Button -->
          <div class="flex justify-center mt-6">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
              Save Changes
            </button>
          </div>

        </div>
      </form>
    </div>
  </div>
@endsection
