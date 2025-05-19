@extends('layouts.admin')

@section('content')
    <h2>Enter Loan</h2>
    <form action="{{ route('admin.loans.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Client Name</label>
            <input type="text" name="client_name" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Loan Amount</label>
            <input type="number" name="amount" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Submit Loan</button>
    </form>
@endsection
