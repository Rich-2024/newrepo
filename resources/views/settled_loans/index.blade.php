@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary fw-bold border-bottom pb-2">📘 Settled Loans</h2>

    <!-- ✅ Success Alert -->
    {{-- @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}
    @include('partials.success')

    <!-- 🔍 Search Form -->
    <form action="{{ route('settled_loans.index') }}" method="GET" class="mb-4 p-3 bg-light rounded shadow-sm">
        <div class="row g-2">
            <div class="col-12 col-md-3">
                <input type="number" name="month" class="form-control" placeholder="📅 Month (1-12)" value="{{ request('month') }}">
            </div>
            <div class="col-12 col-md-3">
                <input type="number" name="year" class="form-control" placeholder="📆 Year (e.g. 2025)" value="{{ request('year') }}">
            </div>
            <div class="col-12 col-md-3">
                <input type="text" name="client" class="form-control" placeholder="👤 Client Name" value="{{ request('client') }}">
            </div>
            <div class="col-12 col-md-3 d-grid">
                <button type="submit" class="btn btn-primary">🔍 Search</button>
            </div>
        </div>
    </form>

    <!-- 📄 Settled Loans Table -->
    <div class="table-responsive shadow-sm">
        <table class="table table-hover align-middle table-bordered">
            <thead class="table-primary text-center">
                <tr>
                    <th>📄 Loan ID</th>
                    <th>👤 Client Name</th>
                    <th>💰 Amount</th>
                    <th>💸 Balance Left</th>
                    <th>✅ Settlement Date</th>
                    <th>⚙️ Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($settledLoans as $loan)
                    <tr>
                        <td class="text-center">{{ $loan->loan_id }}</td>
                        <td>{{ $loan->name }}</td>
                        <td class="text-end text-success">UGX {{ number_format($loan->amount, 2) }}</td>
                        <td class="text-end text-danger">UGX {{ number_format($loan->balance_left, 2) }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($loan->settled_at)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <!-- Hidden Form for Delete -->
                            <form id="delete-form-{{ $loan->id }}" action="{{ route('settled_loans.destroy', $loan->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $loan->id }})">
                                🗑️ Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">🙁 No settled loans found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- 📄 Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $settledLoans->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- SweetAlert2 CDN -->
<!-- Bootstrap JS (for alerts, modals etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JavaScript for SweetAlert2 Delete Confirmation -->
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Deleting this record will permanently remove it.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
