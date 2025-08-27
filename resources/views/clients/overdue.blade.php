@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4 mt-5">
  <h2 class="text-2xl font-semibold mb-4">Repayment Report</h2>
@include('partials.success')
  {{-- Filters --}}
  <form method="GET" action="{{ route('reports.repayments') }}" class="flex space-x-4 mb-6">
    <div>
      <label for="month" class="block text-sm font-medium">Month</label>
      <select name="month" id="month" class="form-select rounded mt-1">
        @for($m = 1; $m <= 12; $m++)
          <option value="{{ $m }}" {{ $m == request('month', now()->month) ? 'selected' : '' }}>
            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
          </option>
        @endfor
      </select>
    </div>
    <div>
      <label for="year" class="block text-sm font-medium">Year</label>
      <select name="year" id="year" class="form-select rounded mt-1">
        @for($y = now()->year; $y >= 2020; $y--)
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

  {{-- Summary Panels --}}
  @if($reportData)
    <h3 class="text-lg font-semibold mb-4">
      Summary for {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div class="bg-gray-100 p-4 rounded shadow">
        <p class="text-sm text-gray-600">Total Loans Settled</p>
        <p class="text-xl font-bold">UGX {{ number_format($reportData['total_loans']) }}</p>
      </div>
      <div class="bg-gray-100 p-4 rounded shadow">
        <p class="text-sm text-gray-600">Total Repayments</p>
        <p class="text-xl font-bold text-green-600">
          UGX {{ number_format($reportData['repayments']->sum('amount')) }}
        </p>
      </div>
      <div class="bg-gray-100 p-4 rounded shadow">
        <p class="text-sm text-gray-600">Balance Due</p>
        <p class="text-xl font-bold text-red-600">UGX {{ number_format($reportData['balance_due']) }}</p>
      </div>
    </div>

    {{-- Table --}}
    <div class="overflow-auto rounded shadow bg-white mb-6">
      <table class="min-w-full table-auto">
        <thead class="bg-gray-100 text-left text-sm font-medium">
          <tr>
            <th class="px-4 py-2">Client</th>
            <th class="px-4 py-2">Loan ID</th>
            <th class="px-4 py-2">Amount Paid</th>
            <th class="px-4 py-2">Date</th>
            <th class="px-4 py-2">Note</th>
            <th class="px-4 py-2">Action</th>
          </tr>
        </thead>
        <tbody class="text-sm text-gray-700">
          @forelse($reportData['repayments'] as $repayment)
            <tr class="border-b">
              <td class="px-4 py-2">
                {{ $repayment->loan->name }}<br>
                <span class="text-xs text-gray-500">{{ $repayment->loan->contact }}</span>
              </td>
              <td class="px-4 py-2">#{{ $repayment->loan->id }}</td>
              <td class="px-4 py-2">UGX {{ number_format($repayment->amount) }}</td>
              <td class="px-4 py-2">{{ \Carbon\Carbon::parse($repayment->payment_date)->format('d M Y') }}</td>
              <td class="px-4 py-2">{{ $repayment->note ?? '-' }}</td>
              <td class="px-4 py-2">
                <button type="button"
                        class="text-indigo-600 hover:underline edit-btn"
                        data-id="{{ $repayment->id }}"
                        data-client="{{ $repayment->loan->name }} – {{ $repayment->loan->contact }}"
                        data-amount="{{ $repayment->amount }}"
                        data-date="{{ $repayment->payment_date }}"
                        data-note="{{ $repayment->note }}">
                  Edit
                </button>
              </td>
              <td>
                                       <a href="{{ route('repayments.logs', $repayment->id) }}"
   class="text-yellow-600 hover:underline font-medium">
   Edit info
</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-4 py-4 text-center text-gray-500">No records found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  @endif
</div>

{{-- Edit Modal --}}
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 px-4">
  <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
    <h3 class="text-xl font-bold mb-4">Edit Repayment</h3>
    <form id="editRepaymentForm" method="POST" action="">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block text-sm font-medium">Client</label>
        <p id="editClientInfo" class="text-gray-700"></p>
      </div>

      <div class="mb-4">
        <label for="edit_amount" class="block text-sm font-medium">Amount Paid</label>
        <input type="text" name="amount" id="edit_amount"
               class="loan-amount w-full border px-3 py-2 rounded" required />
      </div>

      <div class="mb-4">
        <label for="edit_date" class="block text-sm font-medium">Payment Date</label>
        <input type="date" name="payment_date" id="edit_date"
               class="w-full border px-3 py-2 rounded" required />
      </div>

      <div class="mb-4">
        <label for="edit_note" class="block text-sm font-medium">Note</label>
        <textarea name="note" id="edit_note" rows="3"
                  class="w-full border px-3 py-2 rounded"></textarea>
      </div>

      <div class="flex justify-end gap-2">
        <button type="button" onclick="closeEditModal()"
                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
          Cancel
        </button>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
          Save Changes
        </button>
      </div>
    </form>
  </div>
</div>

{{-- Scripts --}}
<script>
  document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', () => {
      const id = button.dataset.id;
      document.getElementById('editClientInfo').textContent = button.dataset.client;
      document.getElementById('edit_amount').value = Number(button.dataset.amount).toLocaleString('en-US');
      document.getElementById('edit_date').value = button.dataset.date;
      document.getElementById('edit_note').value = button.dataset.note || '';
      document.getElementById('editRepaymentForm').action = `/repayment/${id}`;
      document.getElementById('editModal').classList.remove('hidden');
    });
  });

  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
  }

  document.addEventListener('input', e => {
    if (e.target.id === 'edit_amount') {
      let v = e.target.value.replace(/[^0-9.]/g, '');
      const parts = v.split('.');
      if (parts.length > 2) v = parts[0] + '.' + parts.slice(1).join('');
      let [intPart, dec] = v.split('.');
      intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      e.target.value = dec !== undefined ? intPart + '.' + dec : intPart;
    }
  });

  document.getElementById('editRepaymentForm').addEventListener('submit', () => {
    const amt = document.getElementById('edit_amount');
    amt.value = amt.value.replace(/,/g, '');
  });
</script>
@endsection
