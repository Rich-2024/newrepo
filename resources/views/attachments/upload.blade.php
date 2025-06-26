@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-20 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Upload Attachment for {{ $loan->name }}</h2>

    <form method="POST" action="{{ route('attachments.store', $loan->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <input type="file" name="attachment" class="border w-full p-2 rounded" required>
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Upload</button>
    </form>
</div>
@endsection
