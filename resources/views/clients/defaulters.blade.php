@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 mt-5">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Defaulters Report</h2>

    @if ($defaulters->isEmpty())
        <p class="text-gray-500"> Currently No defaulters History found.</p>
    @else
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm sm:text-base">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-600">Name</th>
                        <th class="px-4 py-3 text-left text-gray-600">Contact</th>
                        <th class="px-4 py-3 text-left text-gray-600">Amount</th>
                        <th class="px-4 py-3 text-left text-gray-600">Interest Rate</th>
                        <th class="px-4 py-3 text-left text-gray-600">Total Payable</th>
                        <th class="px-4 py-3 text-left text-gray-600">Balance Left</th>
                        <th class="px-4 py-3 text-left text-gray-600">Settled At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($defaulters as $defaulter)
                        <tr>
                            <td class="px-4 py-3 text-gray-800">{{ $defaulter->name }}</td>
                            <td class="px-4 py-3 text-gray-800">{{ $defaulter->contact }}</td>
                            <td class="px-4 py-3 text-gray-800">UGX {{ number_format($defaulter->amount) }}</td>
                            <td class="px-4 py-3 text-gray-800">{{ $defaulter->interest_rate }}%</td>
                            <td class="px-4 py-3 text-gray-800">UGX {{ number_format($defaulter->total_amount) }}</td>
                            <td class="px-4 py-3 text-red-600 font-bold">UGX {{ number_format($defaulter->balance_left) }}</td>
                            <td class="px-4 py-3 text-gray-800">{{ $defaulter->settled_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

{{-- @extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6 text-red-600">Loan Defaulters</h2>

    @if($defaulters->isEmpty())
        <p class="text-gray-500 text-center py-6">🎉 No defaulters at the moment. All loans are on track!</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white text-sm border border-gray-200">
                <thead class="bg-red-50">
                    <tr>
                        <th class="px-4 py-2 border-b text-left">Client</th>
                        <th class="px-4 py-2 border-b text-left">Contact</th>
                        <th class="px-4 py-2 border-b text-left">Loan Amount</th>
                        <th class="px-4 py-2 border-b text-left">Repaid</th>
                        <th class="px-4 py-2 border-b text-left">Balance</th>
                        <th class="px-4 py-2 border-b text-left">Due Date</th>
                        <th class="px-4 py-2 border-b text-left text-red-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($defaulters as $defaulter)
                        <tr class="hover:bg-red-50">
                            <td class="px-4 py-2 border-b">{{ $defaulter->client->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $defaulter->client->contact }}</td>
                            <td class="px-4 py-2 border-b">UGX {{ number_format($defaulter->loan_amount) }}</td>
                            <td class="px-4 py-2 border-b text-green-600">UGX {{ number_format($defaulter->repaid_amount) }}</td>
                            <td class="px-4 py-2 border-b text-red-500 font-semibold">UGX {{ number_format($defaulter->loan_amount - $defaulter->repaid_amount) }}</td>
                            <td class="px-4 py-2 border-b text-yellow-600">{{ \Carbon\Carbon::parse($defaulter->due_date)->format('M d, Y') }}</td>
                            <td class="px-4 py-2 border-b text-red-700 font-bold">Overdue</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection --}}
