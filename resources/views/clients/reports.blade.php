@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4 mt-5">
    <h2 class="text-2xl font-semibold mb-4">Repayment Report</h2>

    <form method="GET" action="{{ route('reports.repayments') }}" class="flex space-x-4 mb-6">
        <div>
            <label for="month" class="block text-sm font-medium">Month</label>
            <select name="month" id="month" class="form-select rounded mt-1">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $m == request('month', now()->month) ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>
        <div>
            <label for="year" class="block text-sm font-medium">Year</label>
            <select name="year" id="year" class="form-select rounded mt-1">
                @for ($y = now()->year; $y >= 2020; $y--)
                    <option value="{{ $y }}" {{ $y == request('year', now()->year) ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Generate
            </button>
        </div>
    </form>

    @if($reportData)
        <h3 class="text-lg font-semibold mb-4">
            Summary for {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gray-100 p-4 rounded shadow">
                <p class="text-sm text-gray-600">Total Loans Given</p>
                <p class="text-xl font-bold">UGX {{ number_format($reportData['total_loans']) }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded shadow">
                <p class="text-sm text-gray-600">Total Repayments</p>
                <p class="text-xl font-bold text-green-600">UGX {{ number_format($reportData['total_repayments']) }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded shadow">
                <p class="text-sm text-gray-600">Balance Due</p>
                <p class="text-xl font-bold text-red-600">UGX {{ number_format($reportData['balance_due']) }}</p>
            </div>
        </div>

        <h4 class="text-lg font-semibold mb-2">Repayment Records</h4>

        <div class="overflow-auto rounded shadow bg-white">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 text-left text-sm font-medium">
                    <tr>
                        <th class="px-4 py-2">Client</th>
                        <th class="px-4 py-2">Loan ID</th>
                        <th class="px-4 py-2">Amount Paid</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Note</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @forelse($reportData['repayments'] as $repayment)
                        <tr class="border-b">
                            <td class="px-4 py-2">
                                {{ $repayment->loan->name }} <br>
                                <span class="text-xs text-gray-500">{{ $repayment->loan->contact }}</span>
                            </td>
                            <td class="px-4 py-2">#{{ $repayment->loan->id }}</td>
                            <td class="px-4 py-2">UGX {{ number_format($repayment->amount) }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($repayment->payment_date)->format('d M Y') }}</td>
                            <td class="px-4 py-2">{{ $repayment->note ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-4 py-4 text-gray-500">
                                No repayment records found for this period.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
