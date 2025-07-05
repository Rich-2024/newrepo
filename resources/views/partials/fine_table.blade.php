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
                    <th>💰 Fibe Status</th>
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
                            <div id="mark-buttons-{{ $loan->id }}" class="flex space-x-2">
                                @if ($loan->fine_status !== 'paid')
                                    <button
                                        onclick="markChoice({{ $loan->id }}, 'paid')"
                                        id="btn-paid-{{ $loan->id }}"
                                        class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600">
                                        ✅ Paid
                                    </button>
                                @endif
                                @if ($loan->fine_status !== 'not_paid')
                                    <button
                                        onclick="markChoice({{ $loan->id }}, 'not_paid')"
                                        id="btn-notpaid-{{ $loan->id }}"
                                        class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">
                                        ❌ Not Paid
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
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

<!-- Message Box for confirmation -->
<div id="message-box" class="fixed top-4 right-4 p-3 rounded shadow hidden"></div>

<style>
    #message-box {
        background-color: #d1fae5; /* greenish bg */
        border: 1px solid #065f46;
        color: #065f46;
        font-weight: 600;
        transition: opacity 0.3s ease;
        opacity: 1;
        z-index: 9999;
    }
    #message-box.hidden {
        opacity: 0;
        pointer-events: none;
    }
</style>

<script>
    function showMessage(msg, isError = false) {
        const box = document.getElementById('message-box');
        box.textContent = msg;
        box.style.backgroundColor = isError ? '#fee2e2' : '#d1fae5';
        box.style.color = isError ? '#b91c1c' : '#065f46';
        box.classList.remove('hidden');

        setTimeout(() => {
            box.classList.add('hidden');
        }, 3000);
    }

    function markChoice(loanId, status) {
        fetch(`/update-fine-status/${loanId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Remove both buttons
                document.getElementById(`btn-paid-${loanId}`)?.remove();
                document.getElementById(`btn-notpaid-${loanId}`)?.remove();

                // Show a single static button reflecting the status
                let btn = document.createElement('button');
                btn.textContent = status === 'paid' ? '✅ Paid' : '❌ Not Paid';
                btn.className = status === 'paid'
                    ? 'bg-green-500 text-white px-3 py-1 rounded text-xs'
                    : 'bg-red-500 text-white px-3 py-1 rounded text-xs';
                document.getElementById(`mark-buttons-${loanId}`).appendChild(btn);

                showMessage(`Fine status marked as ${status === 'paid' ? 'PAID' : 'NOT PAID'}`);
            } else {
                showMessage('Error saving status.', true);
            }
        })
        .catch(() => {
            showMessage('Error saving status.', true);
        });
    }
</script>

@endsection
