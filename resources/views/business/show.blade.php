@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 mt-6">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-center text-indigo-700">
        Repayments Received from Overdue (Receivables)
    </h1>

    {{-- Search Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <input
            id="searchInput"
            type="search"
            placeholder="Search by borrower name..."
            class="w-full sm:w-1/3 px-4 py-2 text-sm sm:text-base border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
            onkeyup="filterTable()"
        />
    </div>

    {{-- Table --}}
    <div class="overflow-auto rounded shadow bg-white border border-gray-200">
        <table class="min-w-full table-auto text-sm sm:text-base">
            <thead class="bg-indigo-600 text-white text-left font-semibold">
                <tr>
                    <th class="px-4 py-3">Client</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Note</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody id="repaymentTable" class="text-gray-700">
                @forelse($repayments as $repayment)
                    <tr class="border-b hover:bg-indigo-50 transition">
                        <td class="px-4 py-2">
                            <span class="font-medium">{{ $repayment->settledLoan->name ?? 'N/A' }}</span><br>
                            <span class="text-xs text-gray-500">Loan ID: #{{ $repayment->settledLoan->id ?? 'N/A' }}</span>
                        </td>
                        <td class="px-4 py-2">UGX {{ number_format($repayment->amount) }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($repayment->payment_date)->format('d M Y') }}</td>
                        <td class="px-4 py-2 break-words max-w-xs">{{ $repayment->note ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('repayments.prints', $repayment->id) }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm underline">
                                Print Receipt
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-4 py-6 text-gray-500">
                            No repayments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- JavaScript Filter --}}
<script>
    function filterTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('#repaymentTable tr');

        rows.forEach(row => {
            const borrowerCell = row.querySelector('td');
            if (borrowerCell) {
                const text = borrowerCell.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            }
        });
    }
</script>

{{-- Print Style --}}
<style>
@media print {
    input[type="search"],
    .no-print,
    .text-indigo-700,
    a[href*="print"] {
        display: none !important;
    }
    table {
        font-size: 12px;
    }
}
</style>
@endsection
