@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-primary-500 text-start text-base font-medium text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/50 focus:outline-none focus:text-primary-800 focus:bg-primary-100 dark:focus:bg-primary-900/70 focus:border-primary-600 transition duration-150 ease-in-out'
    : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-neutral-600 dark:text-neutral-400 hover:text-neutral-800 dark:hover:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-secondary-800 hover:border-neutral-300 dark:hover:border-secondary-600 focus:outline-none focus:text-neutral-800 dark:focus:text-neutral-200 focus:bg-neutral-50 dark:focus:bg-secondary-800 focus:border-neutral-300 dark:focus:border-secondary-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
