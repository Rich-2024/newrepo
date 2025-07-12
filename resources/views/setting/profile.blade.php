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
                            <label for="name" class="text-gray-700">Business Name</label>
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
                            <div class="relative">
                                <label for="current_password" class="text-gray-700">Current Password</label>
                                <input type="password" id="current_password" name="current_password"
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                       placeholder="••••••••"/>
                                <button type="button"
                                        class="absolute inset-y-0 right-3 flex items-center text-gray-600"
                                        onclick="togglePassword('current_password', this)"
                                        tabindex="-1" aria-label="Toggle current password visibility">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="relative">
                                <label for="new_password" class="text-gray-700">New Password</label>
                                <input type="password" id="new_password" name="new_password"
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                       placeholder="••••••••"/>
                                <button type="button"
                                        class="absolute inset-y-0 right-3 flex items-center text-gray-600"
                                        onclick="togglePassword('new_password', this)"
                                        tabindex="-1" aria-label="Toggle new password visibility">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="relative">
                                <label for="new_password_confirmation" class="text-gray-700">Confirm New Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                       placeholder="••••••••"/>
                                <button type="button"
                                        class="absolute inset-y-0 right-3 flex items-center text-gray-600"
                                        onclick="togglePassword('new_password_confirmation', this)"
                                        tabindex="-1" aria-label="Toggle confirm new password visibility">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
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
        <style>
    .fade-out {
        opacity: 0;
        transition: opacity 0.5s ease-out;
    }
</style>

<script>
    setTimeout(() => {
        ['auth-error', 'success-message', 'error-message', 'validation-errors'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.classList.add('fade-out');
            }
        });
    }, 3000);
</script>


        <!-- JS to trigger file input -->
        <script>
            document.querySelector('label[for="profile_picture"]').addEventListener('click', function () {
                document.getElementById('profile_picture').click();
            });

            function togglePassword(fieldId, btn) {
                const input = document.getElementById(fieldId);
                if (input.type === "password") {
                    input.type = "text";
                    btn.querySelector('svg').innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.958 9.958 0 012.335-3.48m1.732-1.364a3 3 0 014.243 4.243" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    `;
                } else {
                    input.type = "password";
                    btn.querySelector('svg').innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                }
            }
        </script>
    @endif
</div>
@endsection
