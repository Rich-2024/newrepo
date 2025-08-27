@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4 mt-5">
  <h2 class="text-2xl font-semibold mb-4">Edit Logs for Repayment #{{ $repayment->id }}</h2>

  <div class="mb-4 p-4 bg-gray-100 rounded">
    <p><strong>Client:</strong> {{ $repayment->loan?->name ?? 'N/A' }}</p>
    <p><strong>Contact:</strong> {{ $repayment->loan?->contact ?? 'N/A' }}</p>
    <p><strong>Original Amount Paid:</strong> UGX {{ number_format($repayment->amount) }}</p>
    <p><strong>Payment Date:</strong> {{ \Carbon\Carbon::parse($repayment->payment_date)->format('d M Y') }}</p>
  </div>

  @if($logs->isEmpty())
    <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
      No edit history for this repayment.
    </div>
  @else
    <div class="space-y-4">
      @foreach($logs as $log)
        <div class="bg-white shadow rounded p-4 border border-gray-200">
          <div class="text-sm text-gray-600 mb-2">
            <strong>{{ $log->editor->name }}</strong> edited this on
            {{ $log->created_at->format('d M Y H:i') }}
          </div>
          <ul class="list-disc pl-5 text-sm text-gray-800">
            @foreach($log->changes as $field => $old)
              <li>
                <strong>{{ ucfirst($field) }}:</strong> changed from
                <em>{{ is_numeric($old) ? 'UGX ' . number_format($old) : $old }}</em>
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>
  @endif

  <div class="mt-6">
    <a href="{{ url()->previous() }}"
       class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
      ← Back
    </a>
  </div>
</div>
@endsection
