@extends('layouts.app')

@section('content')
@include('partials.success');
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow mt-0 w-100">
    <h2 class="text-2xl font-semibold mb-4 mt-5">Log a Client Repayment</h2>

    <form id="repaymentForm" method="POST" action="{{ route('repayments.store') }}" class="space-y-6">
        @csrf

        {{-- Select Client --}}
      <div>
    <label for="loan_id" class="block text-sm font-medium text-gray-700">Select Client</label>
    <select id="loan_id" name="loan_id" required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
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
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        {{-- Payment Date --}}
        <div>
            <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
            <input type="date" name="payment_date" id="payment_date" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        {{-- Note --}}
        <div>
            <label for="note" class="block text-sm font-medium text-gray-700">Optional Note</label>
            <textarea name="note" id="note" rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="Add comments or notes..."></textarea>
        </div>

        {{-- Buttons --}}
        <div class="pt-6 flex justify-between items-center">
            <a href="{{ url()->previous() }}"
               class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
                Previous
            </a>
            <div class="flex gap-3">
                <button type="reset"
                        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                    Clear
                </button>
                <button type="button" id="reviewRepaymentBtn"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Make Repayment
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Review Modal --}}
<div id="repaymentReviewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded shadow-lg max-w-xl w-full">
        <h2 class="text-xl font-bold mb-4">Review Repayment Details</h2>
        <div id="repaymentReviewContent" class="space-y-2"></div>

        <div class="mt-6 flex justify-end gap-4">
            <button onclick="closeRepaymentReviewModal()" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">
                Cancel
            </button>
            <button onclick="confirmRepaymentSubmission()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Confirm Repayment
            </button>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
    const reviewBtn = document.getElementById('reviewRepaymentBtn');

    reviewBtn.addEventListener('click', () => {
        const client = document.getElementById('loan_id');
        const amount = document.getElementById('amount').value;
        const date = document.getElementById('payment_date').value;
        const note = document.getElementById('note').value;

        let selectedText = client.options[client.selectedIndex].text;

        const reviewContent = document.getElementById('repaymentReviewContent');
        reviewContent.innerHTML = `
            <p><strong>Client:</strong> ${selectedText}</p>
            <p><strong>Amount Paid:</strong> ${amount}</p>
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
