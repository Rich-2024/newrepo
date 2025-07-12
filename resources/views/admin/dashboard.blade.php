@extends('layouts.app')
@section('content')

 <div class="mb-4 mt-6 sm:mb-0 sm:mt-8 md:mb-8 md:mt-10 lg:mb-10 lg:mt-12">
        <h1 class="text-2xl font-semibold text-gray-800">Dashboard Overview</h1>
        <p class="text-sm text-gray-500 mt-3">Welcome, Loan Admin! Here's a summary of your loan system.</p>
        @include('partials.success')
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-sm font-medium text-gray-500">Total Clients</h2>
            <p class="text-2xl font-bold text-blue-600 mt-2">{{ $activeLoansCount + $defaulters->count()  }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-sm font-medium text-gray-500">Active Loans</h2>
            <p class="text-2xl font-bold text-green-600 mt-2">{{ $activeLoansCount }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-sm font-medium text-gray-500">Active Outstanding Repayments</h2>
            <p class="text-2xl font-bold text-yellow-600 mt-2">UGX {{ number_format($totalOutstanding, 0) }}</p>
        </div>

       <div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-sm font-medium text-gray-500">Defaulters & balance left</h2>

    <p class="text-2xl font-bold text-red-600 mt-2">{{ $defaulters->count() }}</p>
    <p class="mt-2">UGX {{ number_format($defaultersTotalOutstanding, 0) }}</p>
</div>


    </div>

   @isset($recentLoans)
<!-- Recent Activity -->
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4 text-gray-700">Recent Activity</h3>
    <ul class="divide-y divide-gray-200 text-sm text-gray-600">
                   <h1><strong>Recent Issued Loans</strong></h1>

        @forelse ($recentLoans as $loan)
            <li class="py-2">
                You have issued new loan of  Ugx:<strong>{{ $loan->amount }}</strong>  to <strong>{{ $loan->name }} ({{ $loan->contact }})</strong>
                - {{ \Carbon\Carbon::parse($loan->loan_date)->format('F j') }} for year {{ \Carbon\Carbon::parse($loan->loan_date)->format('Y') }}
            </li>
        @empty
            <li class="py-2">No recent activity available.</li>
        @endforelse
           <h1><strong>Recent Repayments</strong></h1>

           @forelse ($recentRepayments as $repayment)
            <li class="py-2">
               You have repaid  <strong>Ugx: {{ number_format($repayment->amount, 2) }}</strong>
                    to loan balance of Mr/Ms. <strong>{{ $repayment->loan->name }} ({{ $repayment->loan->contact }})</strong>
                    on {{ \Carbon\Carbon::parse($repayment->payment_date)->format('F j') }} for year {{ \Carbon\Carbon::parse($repayment->payment_date)->format('Y') }}
            </li>
        @empty
            <li class="py-2">No recent activity available.</li>
        @endforelse
    </ul>
</div>
@endisset

@endsection
