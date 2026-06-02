@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium leading-5 text-primary-700 bg-primary-50 focus:outline-none focus:ring-2 focus:ring-primary-500 transition duration-150 ease-in-out'
    : 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium leading-5 text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50 focus:outline-none focus:text-primary-700 focus:bg-primary-50 focus:ring-2 focus:ring-primary-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
