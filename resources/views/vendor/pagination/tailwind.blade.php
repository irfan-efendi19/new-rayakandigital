@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Navigasi Pagination') }}" class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        {{-- Mobile view --}}
        <div class="flex items-center justify-between gap-2 w-full sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center flex-1 gap-1.5 px-4 py-2.5 text-sm font-semibold text-neutral-400 dark:text-neutral-500 bg-neutral-100 dark:bg-secondary-700 border border-neutral-200 dark:border-secondary-600 cursor-not-allowed leading-5 rounded-xl">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    {{ __('pagination.previous') }}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center flex-1 gap-1.5 px-4 py-2.5 text-sm font-semibold text-secondary-700 dark:text-neutral-300 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-secondary-600 leading-5 rounded-xl hover:bg-neutral-50 dark:hover:bg-secondary-700 hover:text-secondary-900 dark:hover:text-white active:bg-neutral-100 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    {{ __('pagination.previous') }}
                </a>
            @endif

            <span class="text-xs font-semibold text-neutral-500 dark:text-neutral-400 whitespace-nowrap shrink-0 tabular-nums">
                {{ $paginator->currentPage() }}/{{ $paginator->lastPage() }}
            </span>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center flex-1 gap-1.5 px-4 py-2.5 text-sm font-semibold text-secondary-700 dark:text-neutral-300 bg-white dark:bg-secondary-800 border border-neutral-300 dark:border-secondary-600 leading-5 rounded-xl hover:bg-neutral-50 dark:hover:bg-secondary-700 hover:text-secondary-900 dark:hover:text-white active:bg-neutral-100 transition ease-in-out duration-150">
                    {{ __('pagination.next') }}
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="inline-flex items-center justify-center flex-1 gap-1.5 px-4 py-2.5 text-sm font-semibold text-neutral-400 dark:text-neutral-500 bg-neutral-100 dark:bg-secondary-700 border border-neutral-200 dark:border-secondary-600 cursor-not-allowed leading-5 rounded-xl">
                    {{ __('pagination.next') }}
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @endif
        </div>

        {{-- Desktop view --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 leading-5">
                    Menampilkan
                    @if ($paginator->firstItem())
                        <span class="font-semibold text-secondary-800 dark:text-neutral-200">{{ $paginator->firstItem() }}</span>–<span class="font-semibold text-secondary-800 dark:text-neutral-200">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    dari <span class="font-semibold text-secondary-800 dark:text-neutral-200">{{ $paginator->total() }}</span> tamu
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-xl shadow-sm gap-1">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-neutral-400 dark:text-neutral-500 bg-neutral-100 dark:bg-secondary-700 border border-neutral-200 dark:border-secondary-600 cursor-not-allowed rounded-xl" aria-hidden="true">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-neutral-600 dark:text-neutral-300 bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 rounded-xl hover:bg-neutral-50 dark:hover:bg-secondary-700 dark:hover:text-white focus:z-10 focus:outline-none focus:ring-2 ring-primary-200 focus:border-primary-400 active:bg-neutral-100 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true" class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-neutral-500 dark:text-neutral-400 select-none">{{ $element }}</span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-bold text-white bg-gradient-to-r from-primary to-primary-600 rounded-xl shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-neutral-600 dark:text-neutral-300 bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 rounded-xl hover:bg-neutral-50 dark:hover:bg-secondary-700 dark:hover:text-white focus:z-10 focus:outline-none focus:ring-2 ring-primary-200 focus:border-primary-400 active:bg-neutral-100 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-neutral-600 dark:text-neutral-300 bg-white dark:bg-secondary-800 border border-neutral-200 dark:border-secondary-600 rounded-xl hover:bg-neutral-50 dark:hover:bg-secondary-700 dark:hover:text-white focus:z-10 focus:outline-none focus:ring-2 ring-primary-200 focus:border-primary-400 active:bg-neutral-100 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-neutral-400 dark:text-neutral-500 bg-neutral-100 dark:bg-secondary-700 border border-neutral-200 dark:border-secondary-600 cursor-not-allowed rounded-xl" aria-hidden="true">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif