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

{{-- Flash Message Auto Dismiss --}}
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
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 15px;
        border-radius: 8px;
        font-weight: bold;
        z-index: 9999;
        display: none;
    }
    .success {
        background-color: #28a745;
        color: white;
        display: block;
    }
    .error {
        background-color: #dc3545;
        color: white;
        display: block;
    }
</style>

{{-- Main Responsive Container --}}
<div class="w-full px-4 sm:px-6 lg:px-8 py-6">

    {{-- Interest Rate Form --}}
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow w-full">
        <h2 class="text-xl sm:text-2xl font-semibold mb-4">Set Interest Rate</h2>

        <form id="interestForm" method="POST" action="{{ route('interest.store') }}" class="space-y-6">
            @csrf

            {{-- Business Name --}}
            <div>
                <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name</label>
                <input type="text" name="business_name" id="business_name" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            </div>

            {{-- Business Size --}}
            <div>
                <label for="business_size" class="block text-sm font-medium text-gray-700">Business Size</label>
                <select name="business_size" id="business_size" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
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
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            </div>

            {{-- Loan Duration --}}
            <div>
                <label for="loan_duration" class="block text-sm font-medium text-gray-700">Loan Duration (Days)</label>
                <input type="number" name="loan_duration" id="loan_duration" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            </div>

            {{-- Form Buttons --}}
            <div class="pt-4 flex flex-col sm:flex-row justify-between items-stretch gap-3">
                <a href="{{ url()->previous() }}"
                   class="w-full sm:w-auto bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition text-center">
                    Previous
                </a>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <button type="reset"
                            class="w-full sm:w-auto bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                        Clear
                    </button>
                    <button type="button" id="reviewInterestBtn"
                            class="w-full sm:w-auto bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        Set Interest Rate
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Review Modal --}}
    <div id="interestReviewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded shadow-lg max-w-xl w-full mx-4">
            <h2 class="text-xl font-bold mb-4">Review Interest Rate Details</h2>
            <div id="interestReviewContent" class="space-y-2"></div>

            <div class="mt-6 flex justify-end gap-4">
                <button onclick="closeInterestReviewModal()" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">
                    Cancel
                </button>
                <button onclick="confirmInterestSubmission()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Confirm & Submit
                </button>
            </div>
        </div>
    </div>

    {{-- Recent Setups Section --}}
    @if(isset($recentSetups) && $recentSetups->count())
        <div class="mt-10">
            <h3 class="text-xl font-semibold mb-4">Recent Interest Setups</h3>
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

{{-- JavaScript for Modal Review --}}
<script>
    const reviewBtn = document.getElementById('reviewInterestBtn');

    reviewBtn.addEventListener('click', () => {
        const name = document.getElementById('business_name').value;
        const size = document.getElementById('business_size').value;
        const rate = document.getElementById('interest_rate').value;
        const duration = document.getElementById('loan_duration').value;

        const content = document.getElementById('interestReviewContent');
        content.innerHTML = `
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
