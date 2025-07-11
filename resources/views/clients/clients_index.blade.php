@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-6">
    @include('partials.success')

    <!-- Page Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-blue-700">Loan Issued Clients</h2>
        <p class="text-gray-500 mt-2">Manage your client loans and attachments here.</p>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('loans.clients.index') }}" class="max-w-lg mx-auto mb-6">
        <div class="flex items-center space-x-3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search client by name..."
                class="flex-grow px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 shadow">
                Search
            </button>

            @if(request('search'))
                <a href="{{ route('loans.clients.index') }}"
                   class="px-5 py-2 bg-gray-100 text-gray-800 border border-gray-300 rounded hover:bg-gray-200 hover:text-black transition duration-150 shadow">
                    ✕ Reset
                </a>
            @endif
        </div>
    </form>

    <!-- Loans Table -->
    <div class="bg-white shadow-md rounded overflow-x-auto">
        <table class="min-w-full text-sm text-gray-800">
            <thead class="bg-blue-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">Client Name</th>
                    <th class="px-6 py-4 text-left">Loan Amount</th>
                    <th class="px-6 py-4 text-left">Issued On</th>
                    <th class="px-6 py-4 text-left">Ends On</th>
                    <th class="px-6 py-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($loans as $loan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">{{ $loan->name }}</td>
                        <td class="px-6 py-4">UGX {{ number_format($loan->amount) }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($loan->end_date)->format('d M Y') }}</td>
                        <td class="px-6 py-4 space-x-4">
                            <a href="{{ route('attachments.upload', $loan->id) }}"
                               class="text-green-600 hover:underline font-medium">Upload</a>
                            <a href="{{ route('attachments.view', $loan->id) }}"
                               class="text-yellow-600 hover:underline font-medium">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                            @if(request('search'))
                                No results found for "<strong>{{ request('search') }}</strong>".
                            @else
                                No clients found.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $loans->appends(request()->query())->links() }}
    </div>
</div>
@endsection
