@props(['number', 'title', 'description'])

<section {{ $attributes->merge(['class' => 'scroll-mt-24 overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm dark:border-secondary-700 dark:bg-secondary-800']) }}>
    <div class="flex items-start gap-3 border-b border-neutral-100 px-5 py-5 dark:border-secondary-700 sm:px-6">
        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-xs font-extrabold text-primary-700 dark:bg-primary-900/30 dark:text-primary-300">{{ $number }}</span>
        <div>
            <h2 class="text-base font-bold text-secondary-900 dark:text-white">{{ $title }}</h2>
            <p class="mt-1 text-xs leading-6 text-neutral-500 dark:text-neutral-400">{{ $description }}</p>
        </div>
    </div>
    <div class="p-5 sm:p-6">{{ $slot }}</div>
</section>
