@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-danger fw-bold border-bottom pb-2">📊 Report Generation</h2>

    <!-- Display success or error messages -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Report Generation Form -->
    <form action="{{ route('reports.generate') }}" method="POST" class="row g-3 bg-light p-4 rounded shadow-sm">
        @csrf
       <div class="col-md-6">
    <label for="report_type" class="form-label">🔍 Report Type</label>
    <select name="report_type" id="report_type" class="form-control" required>
        <option value="" disabled selected>Choose Format</option>
        <option value="csv">CSV</option>
        <option value="pdf">PDF</option>
    </select>
</div>

   
        <div class="col-md-6 d-grid">
                 <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded shadow hover:bg-green-700 transition font-semibold">
                📥 Generate Report
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
    <style>
        .alert {
            margin-top: 20px;
        }
    </style>
@endpush
