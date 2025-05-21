@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 border-l-4 border-amber-800 text-base font-medium text-amber-900 bg-vintage-secondary focus:outline-none focus:text-amber-900 focus:bg-vintage-secondary focus:border-amber-700 transition duration-150 ease-in-out'
            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-700 hover:text-amber-800 hover:bg-vintage-secondary hover:border-amber-300 focus:outline-none focus:text-gray-800 focus:bg-vintage-secondary focus:border-amber-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
