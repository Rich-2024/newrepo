@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">📊 Business Performance Summary</h1>

    <!-- Metrics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <x-dashboard.card label="Repayment Rate" value="{{ $repaymentRate }}%" color="blue" />
        <x-dashboard.card label="Overdue Loans" value="{{ $overduePercentage }}%" color="red" />
        <x-dashboard.card label="Defaulters" value="{{ $defaultersPercentage }}%" color="yellow" />
        <x-dashboard.card label="Fine Collection Rate" value="{{ $fineCollectionRate }}%" color="green" />
        <x-dashboard.card label="Business Growth" value="{{ $growth }}%" color="{{ $growth >= 0 ? 'green' : 'red' }}" />
        <x-dashboard.card label="Total Loans" value="{{ $totalLoans }}" color="gray" />
        <x-dashboard.card label="Outstanding Balance" value="Ugx {{ number_format($totalOutstanding, 2) }}" color="purple" />
        <x-dashboard.card label="Total Repaid" value="Ugx {{ number_format($totalRepaid, 2) }}" color="emerald" />
        <x-dashboard.card label="Fine Potential" value="Ugx {{ number_format($totalFine, 2) }}" color="pink" />
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">📈 Loan Distribution</h2>
            <canvas id="loanChart"></canvas>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">💰 Fine Collection</h2>
            <canvas id="fineChart"></canvas>
        </div>
    </div>

    <!-- Recommendations -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">📌 Recommendations</h2>
        @if(count($recommendations) > 0)
            <ul class="list-disc pl-5 space-y-2 text-gray-800">
                @foreach($recommendations as $note)
                    <li>{{ $note }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No recommendations at this time. Keep up the great work!</p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    const loanCtx = document.getElementById('loanChart').getContext('2d');
    const fineCtx = document.getElementById('fineChart').getContext('2d');

    // Loan performance chart
    new Chart(loanCtx, {
        type: 'doughnut',
        data: {
            labels: ['Active Loans', 'Overdue', 'Defaulters', 'Settled'],
            datasets: [{
                label: 'Loan Status',
                data: [{{ count($activeLoans) }}, {{ $overdueLoans->count() }}, {{ $defaulters->count() }}, {{ $settledLoans->count() }}],
                backgroundColor: ['#3b82f6', '#ef4444', '#f59e0b', '#10b981'],
                borderWidth: 1
            }]
        }
    });

    // Fine collection chart
    new Chart(fineCtx, {
        type: 'bar',
        data: {
            labels: ['Total Fine', 'Collected'],
            datasets: [{
                label: 'Fine (Ksh)',
                data: [{{ $totalFine }}, {{ $collectedFine ?? 0 }}],
                backgroundColor: ['#f43f5e', '#22c55e'],
                borderRadius: 5
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});

</script>
@endpush
