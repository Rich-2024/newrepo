@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-danger fw-bold border-bottom pb-2">💸 Loan Fine Management</h2>

    @include('partials.success')

    <!-- Fine Settings Form -->
    <form action="{{ route('loan_fines.update_settings') }}" method="POST" class="row g-3 p-4 bg-white rounded shadow-sm mb-4">
        @csrf

        {{-- Fine Rate --}}
        <div class="col-md-4">
            <label for="rate" class="form-label fw-semibold">💰 Fine Rate (%) Per Day</label>
            <input 
                type="number" 
                name="rate" 
                step="0.01" 
                class="form-control border border-secondary shadow-sm" 
                value="{{ $rate }}" 
                required
            >
        </div>

        {{-- Fine Duration --}}
        <div class="col-md-4">
            <label for="fine_duration" class="form-label fw-semibold">📅 Fine Duration (Days)</label>
            <input 
                type="number" 
                name="fine_duration" 
                class="form-control border border-secondary shadow-sm" 
                value="{{ $fineDuration }}" 
                min="1" 
                required
            >
        </div>

        {{-- Submit --}}
        <div class="col-md-4 d-grid align-items-end">
            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded shadow hover:bg-green-700 transition font-semibold">
                💾 Save Settings
            </button>
        </div>
    </form>

    <!-- Loan Fine Table -->
    <div id="loan-fine-table" x-data="loanFinePoller" x-init="init()">
        @include('partials.recent', ['loans' => $loans])
    </div>
</div>
@endsection

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('loanFinePoller', () => ({
            interval: null,
            init() {
                this.interval = setInterval(() => this.refreshTable(), 10000);
            },
            refreshTable() {
                fetch("{{ route('loan_fines.table') }}")
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('loan-fine-table').innerHTML = html;
                    });
            }
        }));
    });
</script>
@endpush
