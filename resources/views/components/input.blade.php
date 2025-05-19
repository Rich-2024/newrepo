{{-- resources/views/components/input.blade.php --}}
@props(['label', 'name', 'type' => 'text', 'step' => 'any'])

<div>
    <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" step="{{ $step }}"
           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
           {{ $attributes }} />
</div>
