@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block px-3 py-2 rounded-md bg-gray-700 text-white font-semibold'
            : 'block px-3 py-2 rounded-md text-gray-300 hover:bg-gray-700 hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
