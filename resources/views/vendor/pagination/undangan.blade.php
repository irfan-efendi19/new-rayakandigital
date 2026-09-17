@if($paginator->hasPages())
    <nav aria-label="Navigasi halaman tema" class="flex flex-col items-center justify-between gap-4 sm:flex-row">
        <p class="text-xs text-neutral-500 dark:text-neutral-400">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</p>
        <div class="flex items-center gap-2">
            @if($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="Halaman sebelumnya" class="flex h-11 w-11 items-center justify-center rounded-xl border border-neutral-200 text-neutral-300 dark:border-secondary-700 dark:text-neutral-600"><i class="fa-solid fa-chevron-left text-xs" aria-hidden="true"></i></span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya" class="flex h-11 w-11 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-600 hover:border-primary-400 hover:text-primary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary-500 dark:border-secondary-700 dark:bg-secondary-800 dark:text-neutral-300"><i class="fa-solid fa-chevron-left text-xs" aria-hidden="true"></i></a>
            @endif

            <div class="hidden items-center gap-2 md:flex">
                @foreach($elements as $element)
                    @if(is_string($element))
                        <span class="px-1 text-neutral-500 dark:text-neutral-400">{{ $element }}</span>
                    @else
                        @foreach($element as $page => $url)
                            @if($page === $paginator->currentPage())
                                <span aria-current="page" aria-label="Halaman {{ $page }}" class="flex h-11 min-w-11 items-center justify-center rounded-xl bg-primary-600 px-3 text-xs font-bold text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" aria-label="Ke halaman {{ $page }}" class="flex h-11 min-w-11 items-center justify-center rounded-xl border border-neutral-200 bg-white px-3 text-xs font-semibold text-neutral-600 hover:border-primary-400 hover:text-primary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary-500 dark:border-secondary-700 dark:bg-secondary-800 dark:text-neutral-300">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya" class="flex h-11 w-11 items-center justify-center rounded-xl border border-neutral-200 bg-white text-neutral-600 hover:border-primary-400 hover:text-primary-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary-500 dark:border-secondary-700 dark:bg-secondary-800 dark:text-neutral-300"><i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i></a>
            @else
                <span aria-disabled="true" aria-label="Halaman berikutnya" class="flex h-11 w-11 items-center justify-center rounded-xl border border-neutral-200 text-neutral-300 dark:border-secondary-700 dark:text-neutral-600"><i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i></span>
            @endif
        </div>
    </nav>
@endif
