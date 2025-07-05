@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 mt-6">
    <h1 class="text-2xl sm:text-3xl font-bold text-center text-indigo-700 mb-6">
        Archived Settled Loans
        @include('partials.success')
    </h1>

    {{-- Search Bar --}}
    <div class="mb-4 flex justify-end">
        <input
            type="search"
            id="searchInput"
            placeholder="Search by client name..."
            class="w-full sm:w-1/3 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-indigo-500"
            onkeyup="filterTable()"
        />
    </div>

    {{-- Archived Loans Table --}}
    <div class="overflow-x-auto shadow rounded bg-white">
        <table class="min-w-full table-auto text-sm text-left text-gray-700">
            <thead class="bg-gray-100 font-semibold uppercase text-xs sm:text-sm">
                <tr>
                    <th class="px-4 py-2">Client Name</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Balance Left</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Created At</th>
                    <th class="px-4 py-2">Updated At</th>
                    <th class="px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody id="archivedTable">
                @forelse($archivedLoans as $loan)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $loan->name }}</td>
                        <td class="px-4 py-2">UGX {{ number_format($loan->amount, 2) }}</td>
                        <td class="px-4 py-2">UGX {{ number_format($loan->balance_left, 2) }}</td>
                        <td class="px-4 py-2">{{ ucfirst($loan->status) }}</td>
                        <td class="px-4 py-2">{{ optional($loan->created_at)->format('d M, Y h:i A') }}</td>
                        <td class="px-4 py-2">{{ optional($loan->updated_at)->format('d M, Y h:i A') }}</td>
                        <td class="px-4 py-2 text-center">
                            <button
                                onclick="confirmDelete({{ $loan->id }})"
                                class="text-red-600 hover:text-red-800 font-semibold text-sm"
                            >
                                Delete
                            </button>

                            {{-- Hidden form --}}
                            <form id="delete-form-{{ $loan->id }}"
                                action="{{ route('archived-settled-loans.destroy', $loan->id) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 px-4 py-6">
                            No archived settled loans found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- No match message --}}
        <div id="noMatchMessage" class="hidden text-center text-gray-500 py-6">
            No results match your search.
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
        <h2 class="text-lg font-bold mb-4 text-red-600">Are you sure?</h2>
        <p class="mb-6 text-sm text-gray-700">
            Deleting this record will permanently remove it from your system.
        </p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeModal()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
            <button id="confirmDeleteBtn" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Yes, Delete</button>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
    function filterTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('archivedTable');
        const rows = table.getElementsByTagName('tr');
        let found = false;

        for (let row of rows) {
            const cell = row.getElementsByTagName('td')[0];
            if (cell) {
                const text = cell.textContent.toLowerCase();
                const match = text.includes(filter);
                row.style.display = match ? '' : 'none';
                if (match) found = true;
            }
        }

        document.getElementById('noMatchMessage').style.display = found ? 'none' : 'block';
    }

    let formToDelete = null;

    function confirmDelete(id) {
        formToDelete = document.getElementById('delete-form-' + id);
        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    }

    function closeModal() {
        formToDelete = null;
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('confirmModal').classList.remove('flex');
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (formToDelete) {
            formToDelete.submit();
        }
    });
</script>
@endsection
