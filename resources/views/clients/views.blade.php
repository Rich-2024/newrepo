@extends('layouts.app')

@section('content')
@include('partials.success')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-5">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-4 sm:space-y-0">
        <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">Manage Clients</h2>

        <!-- Search Form -->
        <form method="GET" action="{{ route('clients.index') }}" class="w-full sm:w-auto">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search clients..." 
                    class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm sm:text-base">
                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1116.65 6.65a7.5 7.5 0 010 10.6z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm sm:text-base">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Name</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Contact</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Loan Issued</th>
                  <th class="px-4 py-3 text-left font-semibold text-gray-600">Interest Rate</th>
                  {{-- <th class="px-4 py-3 text-left font-semibold text-gray-600">Loan Duration</th> --}}
                  <th class="px-4 py-3 text-left font-semibold text-gray-600">Loan Issued Date</th>
                  <th class="px-4 py-3 text-left font-semibold text-gray-600">Loan End Date</th>

                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Daily Repayment</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Total to Pay</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Repayment Made</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Balance Left</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Loan Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($clients as $client)
                    @php
                        $repaymentMade = $reps->where('loan_id', $client->id)->sum('amount');
                    @endphp
                    <tr>
                        <td class="px-4 py-3 text-gray-800">{{ $client->name }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $client->contact }}</td>
                        <td class="px-4 py-3 text-gray-800">UGX {{ number_format($client->amount) }}</td>
                     <td class="px-4 py-3 text-gray-800"> {{ number_format($client->interest_rate) }}%</td>
                     {{-- <td class="px-4 py-3 text-gray-800"> {{ number_format($client->loan_duration) }} days</td> --}}
                        <td class="px-4 py-3 text-gray-800">{{ $client->loan_date }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $client->End_date }}</td>


                        <td class="px-4 py-3 text-gray-800">UGX {{ number_format($client->daily_repayment) }}</td>
                        <td class="px-4 py-3 text-gray-800">UGX {{ number_format($client->total_amount) }}</td>
                        <td class="px-4 py-3 text-gray-800">UGX {{ number_format($repaymentMade) }}</td>
                        <td class="px-4 py-3 text-gray-800">UGX {{ number_format($client->balance_to_pay) }}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $client->status }}</td>
                        <td class="px-4 py-3 space-y-1 sm:space-y-0 sm:space-x-2 flex flex-col sm:flex-row">
                            <button type="button" onclick="openEditModal('{{ $client->id }}', '{{ $client->name }}', '{{ $client->contact }}')" 
                                class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">Edit</button>                            

                            <button 
                                onclick="openRepayModal('{{ $client->id }}', '{{ $client->name }}')" 
                                class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600">Repay</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-5 text-center text-gray-500">No clients found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Repayment Modal -->
<div id="repayModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Repayment Form</h3>

        <p class="text-sm text-gray-600 mb-4">
            You're repaying for: <span id="clientName" class="font-medium text-indigo-600"></span>
        </p>

        <form id="repayForm" method="POST" action="{{ route('repayments.store') }}">
            @csrf
            <input type="hidden" name="loan_id" id="modal_loan_id" />

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount (UGX)</label>
                <input type="number" name="amount" id="amount" required
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Enter amount">
            </div>

            <div class="mb-4">
                <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                <input type="date" name="payment_date" id="payment_date" required
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="note" class="block text-sm font-medium text-gray-700">Note (optional)</label>
                <textarea name="note" id="note" rows="3"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Any remarks..."></textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeRepayModal()"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    Cancel
                </button>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Repay
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Client Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full sm:w-96 max-w-full">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Edit Client Details</h3>
        <form id="editForm" method="POST" action="{{ route('clients.update', ['id' => $client]) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="loan_id" id="loan_id" />

            <div class="mb-4">
                <label for="client_name" class="block text-sm font-medium text-gray-700">Client Name</label>
                <input type="text" name="name" id="client_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required />
            </div>

            <div class="mb-4">
                <label for="client_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="text" name="phone" id="client_phone" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required />
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition" onclick="closeModal()">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Save</button>
            </div>
        </form>
    </div>
</div>

@endsection

<script>
    // Open the modal for editing
    function openEditModal(clientId, clientName, clientContact) {
        document.getElementById('loan_id').value = clientId;
        document.getElementById('client_name').value = clientName;
        document.getElementById('client_phone').value = clientContact;
        
        const modal = document.getElementById('editModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // Close the edit modal
    function closeModal() {
        const modal = document.getElementById('editModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Open Repayment Modal
    function openRepayModal(loanId, clientName) {
        document.getElementById('modal_loan_id').value = loanId;
        document.getElementById('clientName').innerText = clientName;
        document.getElementById('repayModal').classList.remove('hidden');
        document.getElementById('repayModal').classList.add('flex');
    }

    // Close Repayment Modal
    function closeRepayModal() {
        document.getElementById('repayModal').classList.add('hidden');
        document.getElementById('repayModal').classList.remove('flex');
    }
</script>
