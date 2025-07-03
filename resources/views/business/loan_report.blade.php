@extends('layouts.app')

@section('content')

<div class="w-full max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-8">

    <h2 class="text-3xl font-extrabold text-gray-900 mb-8 border-b border-gray-300 pb-3">
        Loan Report Analysis
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mb-10">

        <div class="p-6 bg-indigo-50 rounded-lg shadow text-center">
            <h3 class="text-lg font-semibold text-indigo-700 mb-3 uppercase tracking-wide">Total Loans Issued</h3>
            <p class="text-4xl font-extrabold text-indigo-900">{{ $loanStats->total_loans }}</p>
        </div>

        <div class="p-6 bg-green-50 rounded-lg shadow text-center">
            <h3 class="text-lg font-semibold text-green-700 mb-3 uppercase tracking-wide">Total Loans Issued (UGX)</h3>
            <p class="text-4xl font-extrabold text-green-900">UGX {{ number_format($loanStats->total_loan_amount, 2) }}</p>
        </div>

        <div class="p-6 bg-yellow-50 rounded-lg shadow text-center">
            <h3 class="text-lg font-semibold text-yellow-700 mb-3 uppercase tracking-wide">Expected Revenue</h3>
            <p class="text-4xl font-extrabold text-yellow-900">UGX {{ number_format($loanStats->total_balance_to_pay, 2) }}</p>
        </div>

    </div>

    <div class="p-6 bg-blue-50 rounded-lg shadow text-center mb-12">
        <h3 class="text-lg font-semibold text-blue-700 mb-3 uppercase tracking-wide">Total Repayments (UGX)</h3>
        <p class="text-4xl font-extrabold text-blue-900">UGX {{ number_format($totalRepayments, 2) }}</p>
    </div>

    <section class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mb-12 border border-gray-200">
        <h3 class="text-2xl font-semibold text-gray-900 mb-6 border-b border-gray-300 pb-3 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a9 9 0 11-9 9 9 9 0 019-9z" />
            </svg>
            Balance to be Collected
        </h3>

        @php
            use App\Models\Loan;
            use App\Models\Repayment;

            $expectedRevenue = Loan::where('status', 'active')->sum('balance_to_pay');
            $repaymentsMade = Repayment::sum('amount');
            $balanceToCollect = $expectedRevenue - $repaymentsMade;
        @endphp

        <dl class="grid grid-cols-1 md:grid-cols-3 gap-6 text-gray-700 text-lg font-medium">
            <div>
                <dt class="uppercase tracking-wide text-gray-600 mb-1">Expected Revenue</dt>
                <dd class="text-blue-700 font-bold">UGX {{ number_format($expectedRevenue, 2) }}</dd>
            </div>
            <div>
                <dt class="uppercase tracking-wide text-gray-600 mb-1">Repayments Made</dt>
                <dd class="text-green-700 font-bold">UGX {{ number_format($repaymentsMade, 2) }}</dd>
            </div>
            <div>
                <dt class="uppercase tracking-wide text-gray-600 mb-1">Balance to Collect</dt>
                <dd class="text-red-700 font-extrabold text-xl">UGX {{ number_format($balanceToCollect, 2) }}</dd>
            </div>
        </dl>
    </section>

    <section class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md border border-gray-200">
        <h3 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-3.314 0-6 2.686-6 6v4h12v-4c0-3.314-2.686-6-6-6z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v4" />
            </svg>
            Receivables Summary
        </h3>

        @php
            use App\Models\SettledLoan;
            $receivables = SettledLoan::sum('balance_left');
        @endphp

        <p class="text-lg text-gray-700 font-semibold">
            Total Receivables: <span class="text-green-600">UGX {{ number_format($receivables, 2) }}</span>
        </p>
    </section>

</div>

@endsection
