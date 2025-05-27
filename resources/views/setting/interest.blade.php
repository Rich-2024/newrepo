@extends('layouts.app')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
    <div id="messagePopup" class="popup success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any() && !session('success'))
    <div id="messagePopup" class="popup error">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

{{-- Auto-dismiss Flash Messages --}}
<script>
    window.onload = function () {
        const popup = document.getElementById('messagePopup');
        if (popup) {
            setTimeout(() => {
                popup.style.display = 'none';
            }, 3000);
        }
    };
</script>

{{-- Flash Message Styling --}}
<style>
    .popup {
        position: fixed;
        top: 1.25rem;
        left: 50%;
        transform: translateX(-50%);
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        z-index: 9999;
        box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }

    .popup.success {
        background-color: #16a34a; /* Tailwind's green-600 */
        color: white;
        display: block;
    }

    .popup.error {
        background-color: #dc2626; /* Tailwind's red-600 */
        color: white;
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translate(-50%, -20px); }
        to { opacity: 1; transform: translate(-50%, 0); }
    }
</style>

{{-- Main Responsive Container --}}
<div class="w-full px-4 sm:px-6 lg:px-8 py-6">

    {{-- Interest Rate Form --}}
    <div class="bg-white p-6 sm:p-8 rounded-lg shadow w-full max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Set Interest Rate</h2>

        <form id="interestForm" method="POST" action="{{ route('interest.store') }}" class="space-y-6">
            @csrf

            {{-- Business Name --}}
            <div>
                <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name</label>
                <input type="text" name="business_name" id="business_name" required
                       class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" />
            </div>

            {{-- Business Size --}}
            <div>
                <label for="business_size" class="block text-sm font-medium text-gray-700">Business Size</label>
                <select name="business_size" id="business_size" required
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">-- Select Size --</option>
                    <option value="Small">Small</option>
                    <option value="Medium">Medium</option>
                    <option value="Large">Large</option>
                </select>
            </div>

            {{-- Interest Rate --}}
            <div>
                <label for="interest_rate" class="block text-sm font-medium text-gray-700">Interest Rate (%)</label>
                <input type="number" step="0.01" name="interest_rate" id="interest_rate" required
                       class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" />
            </div>

            {{-- Loan Duration --}}
            <div>
                <label for="loan_duration" class="block text-sm font-medium text-gray-700">Loan Duration (Days)</label>
                <input type="number" name="loan_duration" id="loan_duration" required
                       class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" />
            </div>

            {{-- Buttons --}}
            <div class="pt-6 flex flex-col sm:flex-row justify-between items-stretch gap-3">
                <a href="{{ url()->previous() }}"
                   class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded text-sm font-medium text-center">
                    Previous
                </a>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <button type="reset"
                            class="w-full sm:w-auto bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded text-sm font-medium">
                        Clear
                    </button>
                    <button type="button" id="reviewInterestBtn"
                            class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded text-sm font-medium">
                        Set Interest Rate
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Review Modal --}}
    <div id="interestReviewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 px-4">
        <div class="bg-white p-6 sm:p-8 rounded shadow-lg max-w-xl w-full">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Review Interest Rate Details</h2>
            <div id="interestReviewContent" class="text-sm text-gray-700 space-y-2"></div>

            <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">
                <button onclick="closeInterestReviewModal()" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded text-sm font-medium">
                    Cancel
                </button>
                <button onclick="confirmInterestSubmission()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm font-medium">
                    Confirm & Submit
                </button>
            </div>
        </div>
    </div>

    {{-- Recent Setups --}}
    @if(isset($recentSetups) && $recentSetups->count())
        <div class="mt-10">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Recent Interest Setups</h3>
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="w-full min-w-[600px] divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold">Business</th>
                            <th class="px-4 py-2 text-left font-semibold">Size</th>
                            <th class="px-4 py-2 text-left font-semibold">Interest (%)</th>
                            <th class="px-4 py-2 text-left font-semibold">Duration (days)</th>
                            <th class="px-4 py-2 text-left font-semibold">Date Set</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($recentSetups as $setup)
                            <tr>
                                <td class="px-4 py-2">{{ $setup->business_name }}</td>
                                <td class="px-4 py-2">{{ $setup->business_size }}</td>
                                <td class="px-4 py-2">{{ $setup->interest_rate }}%</td>
                                <td class="px-4 py-2">{{ $setup->loan_duration }}</td>
                                <td class="px-4 py-2 text-gray-500">{{ $setup->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $recentSetups->links() }}
            </div>
        </div>
    @else
        <p class="mt-6 text-center text-gray-500">No recent setups found.</p>
    @endif

</div>

{{-- JS for Modal --}}
<script>
    document.getElementById('reviewInterestBtn')?.addEventListener('click', () => {
        const name = document.getElementById('business_name').value;
        const size = document.getElementById('business_size').value;
        const rate = document.getElementById('interest_rate').value;
        const duration = document.getElementById('loan_duration').value;

        document.getElementById('interestReviewContent').innerHTML = `
            <p><strong>Business Name:</strong> ${name}</p>
            <p><strong>Business Size:</strong> ${size}</p>
            <p><strong>Interest Rate:</strong> ${rate}%</p>
            <p><strong>Loan Duration:</strong> ${duration} days</p>
        `;

        document.getElementById('interestReviewModal').classList.remove('hidden');
    });

    function closeInterestReviewModal() {
        document.getElementById('interestReviewModal').classList.add('hidden');
    }

    function confirmInterestSubmission() {
        document.getElementById('interestForm').submit();
    }
</script>

@endsection
