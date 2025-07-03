<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Repayment Receipt - {{ $businessName }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
                background: white;
            }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans p-4 sm:p-6 md:p-10">
    <div class="max-w-4xl mx-auto bg-white p-6 sm:p-10 rounded shadow-md border border-gray-300">

        {{-- Header --}}
        <div class="mb-8 text-center">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-blue-700 uppercase tracking-wide">{{ $businessName }}</h1>
            <h2 class="text-lg sm:text-xl font-semibold mt-1 text-gray-600">Loan Repayment Receipt</h2>
            <p class="text-sm text-gray-500 mt-1">Receipt No: #{{ $repayment->id }}</p>
            <p class="text-sm text-gray-500">Thank you for choosing to grow with us.</p>
        </div>

        {{-- Greeting & Message --}}
        <div class="mb-6 text-justify leading-relaxed text-sm sm:text-base">
            <p>
                Dear <strong class="text-blue-700">{{ $repayment->settledLoan->name }}</strong>,
            </p>
            <p class="mt-3">
                We are pleased to confirm your loan repayment of
                <strong>UGX {{ number_format($repayment->amount, 2) }}</strong>, made on
                <strong>{{ \Carbon\Carbon::parse($repayment->payment_date)->format('d M Y') }}</strong>.
            </p>
            <p class="mt-3">
                Your continued trust in <strong>{{ $businessName }}</strong> means a lot to us.
                Every repayment you make reflects your reliability and helps us continue building a financially empowered community.
            </p>
            <p class="mt-3">
                We appreciate your commitment and look forward to serving you further with integrity, excellence, and care.
            </p>
        </div>

        {{-- Signature Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
            <div>
                <h3 class="font-semibold mb-2">Client Signature</h3>
                <div class="h-20 border-b-2 border-gray-400"></div>
                <p class="text-sm mt-1 text-gray-600">{{ $repayment->settledLoan->name }}</p>
            </div>

            <div>
                <h3 class="font-semibold mb-2">Loan Officer Signature</h3>
                <div class="h-20 border-b-2 border-gray-400"></div>
                <p class="text-sm mt-1 text-gray-600">Loan Admin</p>
            </div>
        </div>

        {{-- Stamp Box --}}
        <div class="mt-10">
            <h3 class="font-semibold mb-2">Company Stamp</h3>
            <div class="w-40 h-24 border-2 border-dashed border-gray-500"></div>
        </div>

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
