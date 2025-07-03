@extends('layouts.app')

@section('content')
@include('partials.success');
<div class="container mt-10">
    <h3 class="mb-4">📄 Overdue Loan Fines</h3>

    <div class="table-responsive shadow-sm">
        <table class="table table-bordered align-middle table-striped">
            <thead class="table-danger text-center">
                <tr>
                    <th>📄 Loan ID</th>
                    <th>👤 Client</th>
                    <th>💳 Balance</th>
                      <th>📆 Daily Rate</th>
                    <th>📆 Start Date</th>
                    <th>📆 Calculated End Date</th>
                    <th>⏱️ Admin Fine Limit (days)</th>
                    <th>⏳ Daily Overdue Days</th>
                    <th>💸 Fine Accrued</th>
                    <th>💰 Repay Fine</th>
                </tr>
            </thead>
            <tbody>
               @php
    $overdueLoans = $loans->filter(function ($loan) {
        return $loan->balance_left > 0 || $loan->fine_total > 0;
    });
@endphp

@forelse($overdueLoans as $loan)
    <tr>
        <td class="text-center">{{ $loan->id }}</td>
        <td>{{ $loan->name }}</td>
        <td class="text-end text-warning">UGX {{ number_format($loan->balance_left, 2) }}</td>
        <td class="text-end text-warning">UGX {{ number_format($rate, 0) }}%</td>
        <td class="text-center">{{ \Carbon\Carbon::parse($loan->created_at)->format('d/m/Y') }}</td>
        <td class="text-center">{{ \Carbon\Carbon::parse($loan->fine_end_date)->format('d/m/Y') }}</td>
        <td class="text-center">every({{ $limit }} days)</td>
        <td class="text-center">{{ $loan->overdue_days }} days</td>
        <td class="text-end text-danger fw-bold">UGX {{ number_format($loan->fine_total, 2) }}</td>
        <td class="text-center">
            <button
                onclick="openRepayModal('{{ $loan->id }}', '{{ $loan->name }}')"
                class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600">
                Repay
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="text-center text-muted py-4">
            📭 No overdue loans found.
        </td>
    </tr>
@endforelse

            </tbody>

            <tfoot>
                <tr class="table-primary">
                    <td colspan="7" class="text-end fw-bold">
                        Total Overdue Balance (original balance)
                    </td>
                   <td colspan="2" class="text-end fw-bold" style="color: red; font-weight: bold; font-size: 1.2rem;">
    UGX {{ number_format($loans->sum('balance_left'), 2) }}
</td>

                </tr>
            </tfoot>
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
@if(session('error'))
    <div class="text-red-500">{{ session('error') }}</div>
@endif

@if($errors->any())
    <ul class="text-red-500">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

    <form id="repayForm" method="POST" action="{{ route('repayments.settles') }}">
    @csrf

    <!-- ✅ Correct input name to match controller validation -->
    <input type="hidden" name="settled_loan_id" id="modal_loan_id" />

    <!-- Optional: Dynamic client name display -->
    <div class="mb-4 text-lg font-semibold text-gray-800">
        You're repaying for: <span id="clientName" class="font-bold text-indigo-600"></span>
    </div>

    <div class="mb-4">
     <label for="amount_copy" class="block text-sm font-medium text-gray-700">Amount (UGX)</label>
<input type="number" name="amount_copy" id="amount_copy" required step="0.01" min="0"
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
<script>
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

@endsection
