@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium leading-5 text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/50 focus:outline-none focus:ring-2 focus:ring-primary-500 transition duration-150 ease-in-out'
    : 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium leading-5 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50/50 dark:hover:bg-primary-900/30 focus:outline-none focus:text-primary-700 dark:focus:text-primary-300 focus:bg-primary-50 dark:focus:bg-primary-900/50 focus:ring-2 focus:ring-primary-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
