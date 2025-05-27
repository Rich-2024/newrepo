@extends('layouts.app')

@section('content')
@include('partials.success')

<div class="w-full max-w-7xl mx-auto bg-white p-6 sm:p-8 rounded-lg shadow mt-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Log a Client Repayment</h2>

    <form id="repaymentForm" method="POST" action="{{ route('repayments.store') }}" class="space-y-6">
        @csrf

        {{-- Select Client --}}
        <div>
            <label for="loan_id" class="block text-sm font-medium text-gray-700">Select Client</label>
            <select id="loan_id" name="loan_id" required
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                <option value="">-- Choose Client --</option>
                @foreach($loans as $loan)
                    <option value="{{ $loan->id }}">{{ $loan->name }} - {{ $loan->contact }}</option>
                @endforeach 
            </select>
        </div>

        {{-- Amount --}}
        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount Paid</label>
            <input type="number" name="amount" id="amount" required
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" />
        </div>

        {{-- Payment Date --}}
        <div>
            <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
            <input type="date" name="payment_date" id="payment_date" required
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" />
        </div>

        {{-- Note --}}
        <div>
            <label for="note" class="block text-sm font-medium text-gray-700">Optional Note</label>
            <textarea name="note" id="note" rows="3"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                placeholder="Add comments or notes..."></textarea>
        </div>

        {{-- Buttons --}}
        <div class="pt-6 flex flex-col sm:flex-row sm:justify-between items-stretch sm:items-center gap-4">
            <a href="{{ url()->previous() }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 text-center px-5 py-2 rounded transition text-sm font-medium w-full sm:w-auto">
                Previous
            </a>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <button type="reset"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded transition text-sm font-medium w-full sm:w-auto">
                    Clear
                </button>
                <button type="button" id="reviewRepaymentBtn"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded transition text-sm font-medium w-full sm:w-auto">
                    Make Repayment
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Review Modal --}}
<div id="repaymentReviewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 px-4">
    <div class="bg-white p-6 sm:p-8 rounded shadow-lg max-w-xl w-full">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4">Review Repayment Details</h2>
        <div id="repaymentReviewContent" class="text-sm text-gray-700 space-y-2">
            {{-- Filled dynamically --}}
        </div>

        <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">
            <button onclick="closeRepaymentReviewModal()" 
                    class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded text-sm font-medium transition">
                Cancel
            </button>
            <button onclick="confirmRepaymentSubmission()" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm font-medium transition">
                Confirm Repayment
            </button>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
    const reviewBtn = document.getElementById('reviewRepaymentBtn');

    reviewBtn.addEventListener('click', () => {
        const client = document.getElementById('loan_id');
        const amount = document.getElementById('amount').value;
        const date = document.getElementById('payment_date').value;
        const note = document.getElementById('note').value;

        let selectedText = client.options[client.selectedIndex]?.text || 'N/A';

        const reviewContent = document.getElementById('repaymentReviewContent');
        reviewContent.innerHTML = `
            <p><strong>Client:</strong> ${selectedText}</p>
            <p><strong>Amount Paid:</strong> UGX ${amount}</p>
            <p><strong>Payment Date:</strong> ${date}</p>
            <p><strong>Note:</strong> ${note || '-'}</p>
        `;

        document.getElementById('repaymentReviewModal').classList.remove('hidden');
    });

    function closeRepaymentReviewModal() {
        document.getElementById('repaymentReviewModal').classList.add('hidden');
    }

    function confirmRepaymentSubmission() {
        document.getElementById('repaymentForm').submit();
    }
</script>
@endsection
