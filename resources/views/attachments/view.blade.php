@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-20 bg-white p-6 rounded shadow ">
    <h2 class="text-xl font-semibold mb-4">Attachments for {{ $loan->name }}</h2>

    @if ($loan->attachments->isEmpty())
        <p class="text-gray-500">No attachments uploaded for this loan.</p>
    @else
        <ul class="list-disc pl-5 space-y-2">
            @foreach ($loan->attachments as $attachment)
                <li>
                    <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ $attachment->file_name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
