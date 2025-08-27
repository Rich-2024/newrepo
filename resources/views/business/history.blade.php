@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 mt-3 px-4">
    <h2 class="text-2xl font-bold mb-4">
        Edit History for {{ $loan->name }} ({{ $loan->contact }})
    </h2>

    @if($editLogs->isEmpty())
        <div class="text-gray-600 italic mb-6">
            This client has no edit history.
        </div>
    @else
        @foreach($editLogs as $log)
            <div class="mb-8 border border-gray-300 rounded-lg p-4 shadow-sm bg-white">
                <div class="mb-2 text-gray-700">
                    <strong>Edited by:</strong> {{ $log->editor->name ?? 'Unknown' }}
                </div>
                <div class="mb-2 text-gray-700">
                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, h:i A') }}
                </div>
                <div class="mb-4 text-gray-700">
                    <strong>Note:</strong> {{ $log->note ?? 'N/A' }}
                </div>

                @php
                    $before = json_decode($log->before_changes, true);
                    $after = json_decode($log->after_changes, true);
                    $differences = array_filter($before, fn($val, $key) => $after[$key] !== $val, ARRAY_FILTER_USE_BOTH);
                @endphp

                <details class="bg-gray-50 border rounded-md p-3 text-sm text-gray-800">
                    <summary class="cursor-pointer font-semibold text-blue-600 hover:underline">
                        View Changes
                    </summary>

                    <table class="w-full text-left mt-4 border text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 border">Field</th>
                                <th class="p-2 border">Before</th>
                                <th class="p-2 border">After</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($differences as $key => $oldValue)
                                <tr>
                                    <td class="p-2 border font-medium">
                                        {{ ucwords(str_replace('_', ' ', $key)) }}
                                    </td>
                                    <td class="p-2 border text-red-600">
                                        {{ is_numeric($oldValue) ? number_format($oldValue) : $oldValue }}
                                    </td>
                                    <td class="p-2 border text-green-600">
                                        {{ isset($after[$key]) && is_numeric($after[$key]) ? number_format($after[$key]) : ($after[$key] ?? '—') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-2 text-center text-gray-500 italic">
                                        No field values changed.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </details>
            </div>
        @endforeach
    @endif

    <div class="mt-4">
        <a href="{{ route('clients.index') }}" class="text-blue-600 hover:underline">← Back to Loans</a>
    </div>
</div>
@endsection
