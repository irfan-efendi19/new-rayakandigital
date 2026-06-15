@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-neutral-300 dark:border-neutral-600 dark:bg-secondary-700 dark:text-neutral-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm']) }}>
