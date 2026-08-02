@props([
    'color' => 'gray', // gray, blue, indigo, red — para sa hover color
])

@php
$colors = [
    'gray' => 'hover:text-gray-700 hover:bg-gray-100',
    'blue' => 'hover:text-blue-600 hover:bg-blue-50',
    'indigo' => 'hover:text-indigo-600 hover:bg-indigo-50',
    'red' => 'hover:text-red-600 hover:bg-red-50',
][$color];
@endphp

<button {{ $attributes->merge(['class' => "p-1.5 text-gray-500 rounded-md transition $colors"]) }}>
    {{ $slot }}
</button>