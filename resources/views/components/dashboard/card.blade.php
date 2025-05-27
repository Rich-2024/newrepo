@props(['label', 'value', 'color' => 'gray'])

<div class="bg-white shadow rounded-lg p-6">
    <p class="text-gray-600">{{ $label }}</p>
    <p class="text-2xl font-bold text-{{ $color }}-600">{{ $value }}</p>
</div>
