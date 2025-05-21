@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-amber-800 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-amber-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-700 hover:text-amber-800 hover:border-amber-500 focus:outline-none focus:text-amber-800 focus:border-amber-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
