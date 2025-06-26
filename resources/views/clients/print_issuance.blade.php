<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loan Issuance - {{ $businessName }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans p-4 sm:p-6 md:p-10">
    <div class="max-w-4xl mx-auto bg-white p-6 sm:p-10 rounded shadow-md border border-gray-300">

        {{-- Header --}}
        <div class="mb-8 text-center">
            {{-- Optional logo --}}
            {{-- <img src="{{ asset('images/logo.png') }}" alt="{{ $businessName }}" class="mx-auto mb-2 w-24"> --}}
            <h1 class="text-3xl font-bold text-blue-700 uppercase">{{ $businessName }}</h1>
            <p class="text-gray-600 italic text-sm">Empowering Financial Growth</p>

            <h2 class="text-xl font-semibold mt-1 text-gray-600">Loan Issuance Certificate</h2>
            <p class="text-sm text-gray-500">An official acknowledgment of loan disbursement.</p>
        </div>

        {{-- Main Message --}}
        <div class="text-sm sm:text-base text-justify leading-relaxed mb-6">
            <p>
                This is to officially certify that <strong class="text-blue-700">{{ $loan->name }}</strong> has been granted a loan of
                <strong>UGX {{ number_format($loan->amount) }}</strong> on
                <strong>{{ \Carbon\Carbon::parse($loan->created_at)->format('d M Y') }}</strong>.
            </p>

            <p class="mt-4">
                This loan is issued under the terms and conditions agreed upon between the client and <strong>{{ $businessName }}</strong>.
                The client is expected to uphold financial responsibility, adhere to the repayment schedule, and maintain communication with our loan team.
            </p>

            <p class="mt-4">
                We believe in your vision and commitment, and are honored to walk this journey with you.
                Thank you for choosing <strong>{{ $businessName }}</strong> as your financial growth partner.
            </p>
        </div>

        {{-- Collateral Section (Writable) --}}
        <div class="mb-8">
            <h3 class="font-semibold text-gray-800 mb-2">Collateral / Security (if provided):</h3>
            <div class="border border-gray-400 rounded p-4 h-32">
                <p class="text-gray-500 italic">To be filled manually before or during signing. Example: Land title, National ID, Car logbook...</p>
            </div>
        </div>

        {{-- Signatures --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
            <div>
                <h3 class="font-semibold mb-2">Client Signature</h3>
                <div class="h-20 border-b-2 border-gray-400"></div>
                <p class="text-sm mt-1 text-gray-600">{{ $loan->name }}</p>
             <p class="text-sm mt-1 text-gray-600">contact:{{ $loan->contact }} </p>

            </div>

            <div>
                <h3 class="font-semibold mb-2">Loan Officer Signature</h3>
                <div class="h-20 border-b-2 border-gray-400"></div>
                <p class="text-sm mt-1 text-gray-600">Loan Admin</p>
                @if($loan->user)
    <p class="text-sm mt-1 text-gray-600">{{ $loan->user->admin_name }}</p>
    <p class="text-sm mt-1 text-gray-600">{{ $loan->user->contact }}</p>
@else
                 <p class="text-sm mt-1 text-gray-600">Contact: _________________________</p>
@endif


            </div>
        </div>

        {{-- Guarantor / Witness Section --}}
        <div class="mt-10">
            <h3 class="font-semibold mb-2">Guarantor / Witness Signature</h3>
            <div class="h-20 border-b-2 border-gray-400"></div>
            <p class="text-sm mt-1 text-gray-600">Name: _________________________</p>
             <p class="text-sm mt-1 text-gray-600">Contact: _________________________</p>

        </div>

        {{-- Stamp --}}
        <div class="mt-10">
            <h3 class="font-semibold mb-2">{{  $businessName }}'s Stamp</h3>
            <div class="w-40 h-24 border-2 border-dashed border-gray-500"></div>
        </div>
<p class="mb-15">
    <span class="font-semibold text-red-600 uppercase">Note:</span>
    Should you require any clarification or assistance during the loan period, please do not hesitate to reach out to our team.
    We kindly urge you to adhere to the agreed policies and terms to avoid any inconvenience during the course of the loan repayment.
    <br class="hidden sm:block mt-2">
    <strong class="text-gray-800">Together, we grow stronger.</strong>
</p>

        {{-- Footer --}}
        <div class="text-center mt-12 text-xs text-gray-500 border-t pt-4">
            &copy; {{ date('Y') }} {{ $businessName }}. All rights reserved.
        </div>

        {{-- Print Button --}}
        <div class="text-center mt-6 no-print">
            <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Print Receipt
            </button>
        </div>
    </div>
</body>
</html>
