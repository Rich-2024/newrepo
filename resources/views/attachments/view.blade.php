@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-20 bg-white p-6 rounded shadow">
    @include('partials.success')
    <h2 class="text-2xl font-semibold mb-6">Attachments for {{ $loan->name }}</h2>

    @if ($loan->attachments->isEmpty())
        <p class="text-gray-500">No attachments uploaded for Our client {{ $loan->name }}</p>
    @else
        <table class="min-w-full table-auto border">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">File Name</th>
                    <th class="px-4 py-2">Uploaded At</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loan->attachments as $attachment)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">
                            <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $attachment->file_name }}
                            </a>
                        </td>
                        <td class="px-4 py-2 text-gray-600">
                            {{ $attachment->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-2 text-center space-x-2">
                            <a href="{{ route('attachments.download', $attachment->id) }}" class="inline-block text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded">
                                Download
                            </a>

                            <form action="{{ route('attachments.destroy', $attachment->id) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this attachment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="mt-6">
        <a href="{{ route('attachments.upload', $loan->id) }}"
           class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            Upload New Attachment
        </a>
    </div>
</div>
@endsection
