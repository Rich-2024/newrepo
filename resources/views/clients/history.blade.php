@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-5">
    <h2 class="text-2xl font-semibold mb-4">Client Loan History</h2>

    <!-- Calendar Container -->
    <div id="calendar"></div>

    <!-- Loan Details Modal -->
    <div id="loanDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <h3 class="text-xl font-semibold mb-4">Loan Details</h3>
            <div id="loanDetailsContent"></div>
            <div class="mt-4 flex justify-end">
                <button onclick="closeLoanDetailsModal()" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Close</button>
            </div>
        </div>
    </div>

    <!-- Recent Loan Activities -->
    <div class="mt-10">
        <h3 class="text-xl font-semibold mb-4">Recent Loan Activities</h3>
        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Client Name</th>
                    <th class="px-4 py-2 text-left">Amount</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($recentLoans as $loan)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $loan->client->name }}</td>
                    <td class="px-4 py-2">{{ $loan->amount }}</td>
                    <td class="px-4 py-2">{{ $loan->payment_date->format('d M Y') }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded-full {{ $loan->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>
</div>

{{-- @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@3.10.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@3.10.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@3.10.0/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: @json($events),
            eventClick: function(info) {
                var loan = info.event.extendedProps.loan;
                var content = `
                    <p><strong>Client:</strong> ${loan.client_name}</p>
                    <p><strong>Amount:</strong> ${loan.amount}</p>
                    <p><strong>Payment Date:</strong> ${loan.payment_date}</p>
                    <p><strong>Status:</strong> ${loan.status}</p>
                    <p><strong>Note:</strong> ${loan.note || 'N/A'}</p>
                `;
                document.getElementById('loanDetailsContent').innerHTML = content;
                document.getElementById('loanDetailsModal').classList.remove('hidden');
            }
        });
        calendar.render();
    });

    function closeLoanDetailsModal() {
        document.getElementById('loanDetailsModal').classList.add('hidden');
    }
</script>
@endpush --}}
@endsection
