@extends('layouts.app')

@section('content')
@php $user = auth()->user(); @endphp

<div class="max-w-7xl mx-auto p-6 mt-0 mt-10">
    <div class="text-center mt-0 mb-8">
        <h2 class="text-3xl font-semibold text-gray-800">Profile Settings</h2>
        <p class="text-gray-600">Update your personal details and account settings.</p>
    </div>

    @if(!$user)
        <div id="auth-error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            You must be logged in to view this page.
        </div>
    @else
        @if(session('success'))
            <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div id="validation-errors" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Auto-hide message script -->
        <script>
            setTimeout(() => {
                const authError = document.getElementById('auth-error');
                const successMsg = document.getElementById('success-message');
                const errorMsg = document.getElementById('error-message');
                const validationErrors = document.getElementById('validation-errors');

                [authError, successMsg, errorMsg, validationErrors].forEach(el => {
                    if (el) {
                        el.style.transition = 'opacity 0.5s ease-out';
                        el.style.opacity = '0';
                        setTimeout(() => el.style.display = 'none', 500);
                    }
                });
            }, 3000);
        </script>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Profile Picture -->
                    <div class="flex justify-center">
                        <div class="relative">
                            <img src="{{ $user->profile_picture ?? 'https://i.pravatar.cc/150?img=3' }}"
                                 alt="Profile Picture"
                                 class="w-32 h-32 rounded-full border-4 border-blue-500 object-cover">

                            <button type="button"
                                    class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 5L3 12l13 7V5z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="text-center mt-2">
                        <label for="profile_picture" class="text-blue-600 cursor-pointer">Change Picture</label>
                        <input type="file" name="profile_picture" id="profile_picture"
                               class="hidden mt-2" accept="image/*"/>
                    </div>

                    <!-- Personal Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="text-gray-700">Full Name</label>
                            <input type="text" id="name" name="name"
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                   value="{{ old('name', $user->name) }}" required/>
                        </div>
                        <div>
                            <label for="email" class="text-gray-700">Email Address</label>
                            <input type="email" id="email" name="email"
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                   value="{{ old('email', $user->email) }}" required/>
                        </div>
                    </div>

                    <!-- Password Update -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Security Settings</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="current_password" class="text-gray-700">Current Password</label>
                                <input type="password" id="current_password" name="current_password"
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                       placeholder="••••••••"/>
                            </div>
                            <div>
                                <label for="new_password" class="text-gray-700">New Password</label>
                                <input type="password" id="new_password" name="new_password"
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                       placeholder="••••••••"/>
                            </div>
                            <div>
                                <label for="new_password_confirmation" class="text-gray-700">Confirm New Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                       placeholder="••••••••"/>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-center mt-6">
                        <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- JS to trigger file input -->
        <script>
            document.querySelector('label[for="profile_picture"]').addEventListener('click', function () {
                document.getElementById('profile_picture').click();
            });
        </script>
    @endif {{-- Close @if(!$user) --}}
</div>
@endsection
