@extends('layouts.app')

@section('content')

<div class="bg-white rounded-lg shadow p-6 max-w-5xl mx-auto mt-3">
    <h2 class="text-2xl font-semibold mb-6 mt-0">Register New Clients & Loans</h2>
@include('partials.success')
    <form id="clientForm" method="POST" action="{{ route('storeclients') }}">
        @csrf

        <div id="formContainer" class="flex transition-transform duration-500 ease-in-out h-full w-full">
            <!-- Client 1 slide -->
            <div class="form-slide w-full px-4 shrink-0 h-full flex flex-col justify-center space-y-6 py-0 t-0">
                <h3 class="text-lg font-semibold">Client 1</h3>
                <div>
                    <label>Client Name</label>
                    <input type="text" name="clients[0][name]" required class="w-full border px-3 py-2 rounded" />
                </div>
                <div>
                    <label>Contact</label>
                    <input type="text" name="clients[0][contact]" required class="w-full border px-3 py-2 rounded" />
                </div>
                <div>
                    <label>Loan Amount</label>
                    <input type="text" name="clients[0][amount]" required class="loan-amount w-full border px-3 py-2 rounded" />
                </div>
                <div>
                    <label>Loan Date</label>
                    <input type="date" name="clients[0][loan_date]" required class="w-full border px-3 py-2 rounded" />
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <div class="flex justify-between items-center mt-6 flex-wrap gap-2">
            <button type="button" id="prevBtn" class="bg-gray-300 text-gray-800 px-3 py-1.5 rounded hover:bg-gray-400 transition text-sm">Previous</button>
            <div class="flex gap-2 justify-end flex-1 max-w-md">
                <button type="button" id="addClientBtn" class="bg-purple-600 text-white px-3 py-1.5 rounded hover:bg-purple-700 transition text-sm shadow-md">+ Add Client</button>
                <button type="button" id="nextBtn" class="bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 transition text-sm shadow-md">Next</button>
                <button type="button" id="reviewBtn" class="bg-green-600 text-white px-3 py-1.5 rounded hover:bg-green-700 transition text-sm shadow-md">Submit</button>
            </div>
        </div>
    </form>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded shadow-lg max-w-3xl w-full">
        <h2 class="text-xl font-bold mb-4">Review All Clients</h2>
        <div id="reviewContent" class="space-y-4 max-h-[60vh] overflow-y-auto"></div>
        <div class="mt-6 flex justify-end gap-4">
            <button onclick="resetForm()" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Reset</button>
            <button id="confirmBtn" onclick="confirmSubmission()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Confirm Submission</button>
        </div>
    </div>
</div>

<script>
    let currentSlide = 0;
    let clientCount = 1;

    const formContainer = document.getElementById('formContainer');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const addClientBtn = document.getElementById('addClientBtn');
    const reviewBtn = document.getElementById('reviewBtn');

    function updateSlider() {
        const slides = document.querySelectorAll('.form-slide');
        formContainer.style.width = `${slides.length * 100}%`;
        slides.forEach(slide => {
            slide.style.width = `${100 / slides.length}%`;
        });
        formContainer.style.transform = `translateX(-${currentSlide * (100 / slides.length)}%)`;
        prevBtn.disabled = currentSlide === 0;
    }

    function addNewClientSlide() {
        const index = clientCount;
        const slide = document.createElement('div');
        slide.className = 'form-slide w-full px-4 shrink-0 h-full flex flex-col justify-center space-y-6';

        slide.innerHTML = `
            <h3 class="text-lg font-semibold">Client ${index + 1}</h3>
            <div>
                <label>Client Name</label>
                <input type="text" name="clients[${index}][name]" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div>
                <label>Contact</label>
                <input type="text" name="clients[${index}][contact]" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div>
                <label>Loan Amount</label>
                <input type="text" name="clients[${index}][amount]" required class="loan-amount w-full border px-3 py-2 rounded" />
            </div>
            <div>
                <label>Loan Date</label>
                <input type="date" name="clients[${index}][loan_date]" required class="w-full border px-3 py-2 rounded" />
            </div>
        `;
        formContainer.appendChild(slide);
        clientCount++;
        updateSlider();
    }

    prevBtn.addEventListener('click', () => {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlider();
        }
    });

    nextBtn.addEventListener('click', () => {
        const slides = document.querySelectorAll('.form-slide');
        if (currentSlide < slides.length - 1) {
            currentSlide++;
        } else {
            addNewClientSlide();
            currentSlide++;
        }
        updateSlider();
    });

    addClientBtn.addEventListener('click', () => {
        addNewClientSlide();
        currentSlide = document.querySelectorAll('.form-slide').length - 1;
        updateSlider();
    });

    reviewBtn.addEventListener('click', openReviewModal);

    function openReviewModal() {
        const slides = document.querySelectorAll('.form-slide');
        const reviewContent = document.getElementById('reviewContent');
        reviewContent.innerHTML = '';

        slides.forEach((slide, i) => {
            const inputs = slide.querySelectorAll('input');
            let clientHTML = `<h3 class="font-bold text-lg mb-2">Client ${i + 1}</h3><ul class="space-y-1">`;
            inputs.forEach(input => {
                const label = input.previousElementSibling?.innerText || input.name;
                clientHTML += `<li><strong>${label}:</strong> ${input.value}</li>`;
            });
            clientHTML += '</ul>';
            reviewContent.insertAdjacentHTML('beforeend', `<div class="border p-4 rounded bg-gray-100 mb-2">${clientHTML}</div>`);
        });

        document.getElementById('reviewModal').classList.remove('hidden');
    }

    function resetForm() {
        document.getElementById('clientForm').reset();

        const slides = document.querySelectorAll('.form-slide');
        slides.forEach((slide, index) => {
            if (index > 0) slide.remove();
        });

        clientCount = 1;
        currentSlide = 0;
        updateSlider();

        document.getElementById('reviewModal').classList.add('hidden');
    }

    function confirmSubmission() {
        // Remove commas before submit
        document.querySelectorAll('.loan-amount').forEach(input => {
            input.value = input.value.replace(/,/g, '');
        });
        document.getElementById('clientForm').submit();
    }

    // Comma separator on input (supports dynamically added inputs via event delegation)
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('loan-amount')) {
            let value = e.target.value.replace(/,/g, '').replace(/\D/g, '');
            if (value === '') {
                e.target.value = '';
                return;
            }
            e.target.value = Number(value).toLocaleString('en-US');
        }
    });

    // Initialize slider width
    updateSlider();
</script>

@endsection
