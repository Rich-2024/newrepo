@extends('layouts.app')

@section('content')
@include('partials.success');
<div class="bg-white rounded-lg shadow p-6 max-w-5xl mx-auto mt-3">
    <h2 class="text-2xl font-semibold mb-6 mt-0">Register New Clients & Loans</h2>

    <form id="clientForm" method="POST" action="{{ route('storeclients') }}">
        @csrf

        <div id="formContainer" class="flex transition-transform duration-500 ease-in-out h-full w-full">
            <div id="formContainer" class="flex transition-transform duration-500 ease-in-out h-full w-full">
                <div class="form-slide w-full px-4 shrink-0 h-full flex flex-col justify-center space-y-10 py-0 t-0">
                    <h3 class="text-lg font-semibold">Client 1</h3>
                    <x-input label="Client Name" name="clients[0][name]" required />
                    <x-input label="Contact" name="clients[0][contact]" required />
                    <x-input type="number" label="Loan Amount" name="clients[0][amount]" required />
                    <x-input type="date" label="Loan Date" name="clients[0][loan_date]" required />
                    {{-- <x-input type="number" label="Duration (days)" name="clients[0][duration]" required /> --}}
                    {{-- <x-input type="number" label="Interest Rate (%)" name="clients[0][interest]" step="0.1" required /> --}}
                </div>
            </div>
        </div>
    </form>

    {{-- Navigation --}}
    <div class="flex justify-between items-center mt-6">
        <button type="button" id="prevBtn" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Previous</button>
        <div class="flex gap-3">
            <button type="button" id="addClientBtn" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">+ Add Client</button>
            <button type="button" id="nextBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Next</button>
            <button type="button" id="reviewBtn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Submit</button>
        </div>
    </div>
</div>

{{-- Review Modal --}}
<div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded shadow-lg max-w-3xl w-full">
        <h2 class="text-xl font-bold mb-4">Review All Clients</h2>
        <div id="reviewContent" class="space-y-4 max-h-[60vh] overflow-y-auto"></div>
        <div class="mt-6 flex justify-end gap-4">
            <button onclick="closeReviewModal()" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
            <button onclick="confirmSubmission()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Confirm Submission</button>
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

    const updateSlider = () => {
        const slides = document.querySelectorAll('.form-slide');
        formContainer.style.width = `${slides.length * 100}%`;
        slides.forEach(slide => {
            slide.style.width = `${100 / slides.length}%`;
        });
        formContainer.style.transform = `translateX(-${currentSlide * (100 / slides.length)}%)`;
        prevBtn.disabled = currentSlide === 0;
    };

    const addNewClientSlide = () => {
        const index = clientCount;
        const slide = document.createElement('div');
        slide.className = 'form-slide w-full px-4 shrink-0 h-full flex flex-col justify-center space-y-4';
        slide.innerHTML = `
            <h3 class="text-lg font-semibold">Client ${index + 1}</h3>
            <div><label>Client Name</label><input type="text" name="clients[${index}][name]" required class="w-full border px-3 py-2 rounded"/></div>
            <div><label>Contact</label><input type="text" name="clients[${index}][contact]" required class="w-full border px-3 py-2 rounded"/></div>
            <div><label>Loan Amount</label><input type="number" name="clients[${index}][amount]" required class="w-full border px-3 py-2 rounded"/></div>
            <div><label>Loan Date</label><input type="date" name="clients[${index}][loan_date]" required class="w-full border px-3 py-2 rounded"/></div>
    
        `;
        formContainer.appendChild(slide);
        clientCount++;
        updateSlider();
    };

    prevBtn.addEventListener('click', () => {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlider();
        }
    });

    nextBtn.addEventListener('click', () => {
        const totalSlides = document.querySelectorAll('.form-slide').length;
        if (currentSlide < totalSlides - 1) {
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

    reviewBtn.addEventListener('click', () => openReviewModal());

    function openReviewModal() {
        const slides = document.querySelectorAll('.form-slide');
        const reviewContent = document.getElementById('reviewContent');
        reviewContent.innerHTML = '';

        slides.forEach((slide, i) => {
            const inputs = slide.querySelectorAll('input');
            const clientDiv = document.createElement('div');
            clientDiv.className = "border p-4 rounded bg-gray-100";

            let list = `<h3 class="font-bold text-lg mb-2">Client ${i + 1}</h3><ul class="space-y-1">`;
            inputs.forEach(input => {
                const label = input.previousElementSibling?.innerText || input.name;
                list += `<li><strong>${label}:</strong> ${input.value}</li>`;
            });
            list += '</ul>';

            clientDiv.innerHTML = list;
            reviewContent.appendChild(clientDiv);
        });

        document.getElementById('reviewModal').classList.remove('hidden');
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').classList.add('hidden');
    }

    function confirmSubmission() {
        document.getElementById('clientForm').submit();
    }

    updateSlider();
</script>
@endsection
