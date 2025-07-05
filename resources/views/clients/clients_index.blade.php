@extends('layouts.app')


@section('content')
<div class="container mx-auto px-4 py-6 mt-5">
    @include('partials.success')
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">Loan Issued Clients</h2>

    <!-- Search -->
    <form method="GET" action="{{ route('loans.clients.index') }}" class="mb-6 max-w-md mx-auto">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search client by name..."
            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-300">
    </form>

    <!-- Clients & Loans Table -->
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-3 text-left">Client Name</th>
                    <th class="px-4 py-3 text-left">Loan Amount</th>
                    <th class="px-4 py-3 text-left">Issued On</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 divide-y">
                @forelse($loans as $loan)
                    <tr>
                        <td class="px-4 py-3">{{ $loan->name }}</td>
                        <td class="px-4 py-3">UGX {{ number_format($loan->amount) }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($loan->created_at)->format('d M Y') }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('loans.printIssuance', $loan->id) }}" target="_blank"
                               class="text-blue-600 hover:underline">Print</a>

                            <a href="{{ route('attachments.upload', $loan->id) }}"
                               class="text-green-600 hover:underline">Upload</a>

                            <a href="{{ route('attachments.view', $loan->id) }}"
                               class="text-yellow-600 hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">No clients found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $loans->appends(request()->query())->links() }}
    </div>
</div>
@endsection
