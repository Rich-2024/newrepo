@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Dashboard Overview</h1>
        <p class="text-sm text-gray-500">Welcome, Loan Admin! Here's a summary of your loan system.</p>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-sm font-medium text-gray-500">Total Clients</h2>
            <p class="text-2xl font-bold text-blue-600 mt-2">142</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-sm font-medium text-gray-500">Active Loans</h2>
            <p class="text-2xl font-bold text-green-600 mt-2">65</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-sm font-medium text-gray-500">Outstanding Repayments</h2>
            <p class="text-2xl font-bold text-yellow-600 mt-2">  UGX {{ number_format($totalOutstanding) }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-sm font-medium text-gray-500">Defaulters</h2>
            <p class="text-2xl font-bold text-red-600 mt-2">8</p>
        </div>
    </div>

   @isset($recentLoans)
<!-- Recent Activity -->
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4 text-gray-700">Recent Activity</h3>
    <ul class="divide-y divide-gray-200 text-sm text-gray-600">
        @forelse ($recentLoans as $loan)
            <li class="py-2">
                New loan issued to <strong>{{ $loan->name }}</strong> 
                - {{ \Carbon\Carbon::parse($loan->created_at)->format('F j') }}
            </li>
        @empty
            <li class="py-2">No recent activity available.</li>
        @endforelse
    </ul>
</div>
@endisset

@endsection
