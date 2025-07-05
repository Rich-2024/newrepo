@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 mt-5">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Defaulters Report</h2>
@if(session('success'))
    <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div id="flash-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<script>
    // Auto-hide flash message after 3 seconds (3000 ms)
    setTimeout(() => {
        const flash = document.getElementById('flash-message');
        if (flash) {
            // fade out effect (optional)
            flash.style.transition = 'opacity 0.5s ease';
            flash.style.opacity = '0';

            // after fade out, remove from DOM
            setTimeout(() => flash.remove(), 500);
        }
    }, 3000);
</script>

{{-- @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif --}}
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
                        <th class="px-4 py-3 text-left text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($defaulters as $defaulter)
                        <tr>
                            <td class="px-4 py-3 text-gray-800">{{ $defaulter->name }}</td>
                            <td class="px-4 py-3 text-gray-800">{{ $defaulter->contact }}</td>
                            <td class="px-4 py-3 text-gray-800">UGX {{ number_format($defaulter->amount_copy) }}</td>
                            <td class="px-4 py-3 text-gray-800">{{ $defaulter->interest_rate }}%</td>
                            <td class="px-4 py-3 text-gray-800">UGX {{ number_format($defaulter->total_amount) }}</td>
                            <td class="px-4 py-3 text-red-600 font-bold">UGX {{ number_format($defaulter->balance_left) }}</td>
  <td class="text-center">
            <button
                onclick="openRepayModal('{{ $defaulter->id }}', '{{ $defaulter->name }}')"
                class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600">
                Repay
            </button>
        </td>                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
  <!-- Repayment Modal -->
<div id="repayModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Repayment Form</h3>

        <p class="text-sm text-gray-600 mb-4">
            You're repaying for: <span id="clientName" class="font-medium text-indigo-600"></span>
        </p>


        {{-- @if(session('error'))
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <form id="repayForm" method="POST" action="{{ route('repayments.settles') }}">
            @csrf
            <input type="hidden" name="settled_loan_id" id="modal_loan_id" />

            <div class="mb-4">
                <label for="amount_copy" class="block text-sm font-medium text-gray-700">Amount (UGX)</label>
                <input type="number" name="amount_copy" id="amount_copy" required step="0.01" min="0"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Enter amount">
            </div>

            <div class="mb-4">
                <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                <input type="date" name="payment_date" id="payment_date" required value="{{ date('Y-m-d') }}"
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

<script>
    function openRepayModal(loanId, clientName) {
        document.getElementById('modal_loan_id').value = loanId;
        document.getElementById('clientName').innerText = clientName;
        document.getElementById('repayModal').classList.remove('hidden');
        document.getElementById('repayModal').classList.add('flex');
    }

    function closeRepayModal() {
        document.getElementById('repayModal').classList.add('hidden');
        document.getElementById('repayModal').classList.remove('flex');
    }
</script>

@endsection

