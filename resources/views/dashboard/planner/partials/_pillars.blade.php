<section aria-labelledby="planner-pillars-title"
    x-data="{
        activeTab: localStorage.getItem('plannerActiveTab') || '{{ $pillars[0]['key'] }}',
        validTabs: @js(collect($pillars)->pluck('key')->values()),
        init() {
            if (!this.validTabs.includes(this.activeTab)) {
                this.activeTab = '{{ $pillars[0]['key'] }}';
                localStorage.setItem('plannerActiveTab', this.activeTab);
            }
            this.$nextTick(() => this.scrollTabIntoView(this.activeTab, false));
        },
        setActiveTab(key) {
            this.activeTab = key;
            localStorage.setItem('plannerActiveTab', key);
            this.$nextTick(() => this.scrollTabIntoView(key, true));
        },
        moveTab(direction) {
            const currentIndex = this.validTabs.indexOf(this.activeTab);
            const nextIndex = (currentIndex + direction + this.validTabs.length) % this.validTabs.length;
            const nextKey = this.validTabs[nextIndex];
            this.setActiveTab(nextKey);
            this.$nextTick(() => this.$refs.tabs.querySelector(`[data-tab='${nextKey}']`)?.focus());
        },
        scrollTabIntoView(key, smooth) {
            const container = this.$refs.tabs;
            if (!container || container.scrollWidth <= container.clientWidth) return;
            const btn = Array.from(container.children).find((el) => el.dataset.tab === key);
            if (btn) {
                container.scrollTo({
                    left: Math.max(0, btn.offsetLeft - (container.clientWidth / 2) + (btn.offsetWidth / 2)),
                    behavior: smooth ? 'smooth' : 'auto',
                });
            }
        }
    }"
    class="overflow-hidden rounded-[2rem] border border-neutral-200 bg-white shadow-[0_18px_45px_-28px_rgba(15,23,42,0.35)] dark:border-secondary-700 dark:bg-secondary-800">
    <div class="flex flex-col gap-4 border-b border-neutral-200 px-5 py-5 dark:border-secondary-700 sm:flex-row sm:items-end sm:justify-between sm:px-6">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-primary-600 dark:text-primary-400">Pusat persiapan</p>
            <h2 id="planner-pillars-title" class="mt-1 font-heading text-xl font-bold text-secondary-900 dark:text-white sm:text-2xl">Semua rencana dalam satu tempat</h2>
            <p class="mt-1 max-w-2xl text-xs leading-5 text-neutral-500 dark:text-neutral-400">Buka modul yang ingin dikerjakan. Jumlah di setiap kartu membantu melihat progres tanpa masuk satu per satu.</p>
        </div>
        <div class="flex items-center gap-2 text-[10px] font-medium text-neutral-400 dark:text-neutral-500 lg:hidden">
            <i class="fa-solid fa-arrows-left-right" aria-hidden="true"></i>
            Geser untuk melihat semua modul
        </div>
    </div>

    <div x-ref="tabs" role="tablist" aria-label="Pilar wedding planner"
        class="scrollbar-hide flex gap-2 overflow-x-auto border-b border-neutral-200 bg-neutral-50/80 px-3 py-3 dark:border-secondary-700 dark:bg-secondary-900/45 sm:px-5 lg:grid lg:grid-cols-4 lg:overflow-visible lg:p-5">
        @foreach($pillars as $pillar)
            <button type="button" role="tab" @click="setActiveTab('{{ $pillar['key'] }}')" data-tab="{{ $pillar['key'] }}"
                id="planner-tab-{{ strtolower($pillar['key']) }}"
                aria-controls="planner-panel-{{ strtolower($pillar['key']) }}"
                @keydown.right.prevent="moveTab(1)" @keydown.left.prevent="moveTab(-1)"
                :aria-selected="activeTab === '{{ $pillar['key'] }}'"
                class="group flex min-w-[148px] shrink-0 items-center gap-2.5 rounded-2xl border px-3 py-2.5 text-left text-xs font-semibold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-400 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-secondary-900 lg:min-w-0 lg:px-3.5 lg:py-3"
                :class="activeTab === '{{ $pillar['key'] }}'
                    ? 'border-primary/20 bg-white text-primary shadow-md shadow-primary-500/5 ring-1 ring-primary-500/10 dark:border-primary-400/30 dark:bg-secondary-800 dark:text-primary-300'
                    : 'border-transparent text-neutral-500 hover:border-neutral-200 hover:bg-white hover:text-secondary-800 dark:text-neutral-400 dark:hover:border-secondary-600 dark:hover:bg-secondary-700 dark:hover:text-white'">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl {{ $pillar['bg'] }} {{ $pillar['color'] }}">
                    <i class="fa-solid {{ $pillar['icon'] }} text-[11px]" aria-hidden="true"></i>
                </span>
                <span class="min-w-0 flex-1">
                    <span class="block truncate">{{ $pillar['label'] }}</span>
                    <span class="mt-0.5 hidden truncate text-[9px] font-medium text-neutral-400 dark:text-neutral-500 lg:block">{{ $pillar['description'] }}</span>
                </span>
                <span class="inline-flex min-w-[24px] shrink-0 items-center justify-center rounded-full px-1.5 py-0.5 text-[9px] font-bold {{ $pillar['bg'] }} {{ $pillar['color'] }}">
                    @if($pillar['key'] === 'CHECKLIST')
                        {{ $checklistCompletedItems }}/{{ $checklistTotalItems }}
                    @elseif($pillar['key'] === 'ADMINISTRATION')
                        {{ $adminCompletedItems }}/{{ $adminTotalItems }}
                    @else
                        {{ $itemsByCategory[$pillar['key']]->count() }}
                    @endif
                </span>
            </button>
        @endforeach
    </div>

    <div x-data="plannerChecklist()">
        @foreach($pillars as $pillar)
            <div x-show="activeTab === '{{ $pillar['key'] }}'" x-cloak role="tabpanel"
                id="planner-panel-{{ strtolower($pillar['key']) }}"
                aria-labelledby="planner-tab-{{ strtolower($pillar['key']) }}" tabindex="0"
                class="p-3 sm:p-6 lg:p-7">
                @if($pillar['key'] === 'CALENDAR')
                    @include('dashboard.planner.partials.pillars._calendar')
                @elseif($pillar['key'] === 'CHECKLIST')
                    @include('dashboard.planner.partials.pillars._checklist')
                @elseif($pillar['key'] === 'ADMINISTRATION')
                    @include('dashboard.planner.partials.pillars._administration')
                @elseif($pillar['key'] === 'VENDOR')
                    @include('dashboard.planner.partials.pillars._vendor')
                @elseif($pillar['key'] === 'ENGAGEMENT')
                    @include('dashboard.planner.partials.pillars._engagement')
                @elseif($pillar['key'] === 'PRE_WEDDING')
                    @include('dashboard.planner.partials.pillars._pre-wedding')
                @elseif($pillar['key'] === 'SESERAHAN')
                    @include('dashboard.planner.partials.pillars._seserahan')
                @elseif($pillar['key'] === 'BUDGET')
                    @include('dashboard.planner.partials.pillars._budget')
                @else
                    @include('dashboard.planner.partials.pillars._generic')
                @endif
            </div>
        @endforeach
    </div>
</section>
