<div x-data="{
                activeTab: localStorage.getItem('plannerActiveTab') || '{{ $pillars[0]['key'] }}',
                init() {
                    this.$nextTick(() => this.scrollTabIntoView(this.activeTab, false));
                },
                setActiveTab(key) {
                    this.activeTab = key;
                    localStorage.setItem('plannerActiveTab', key);
                    this.$nextTick(() => this.scrollTabIntoView(key, true));
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
    class="overflow-hidden rounded-3xl border border-neutral-200/80 bg-white shadow-[0_16px_40px_-24px_rgba(15,23,42,0.25)] dark:border-secondary-700/70 dark:bg-secondary-800">
    {{-- Tabs --}}
    <div x-ref="tabs"
        class="flex overflow-x-auto gap-1.5 border-b border-neutral-200/80 bg-neutral-50/70 px-2 py-2 scrollbar-hide dark:border-secondary-700/60 dark:bg-secondary-700/40">
        @foreach($pillars as $pillar)
            <button type="button" @click="setActiveTab('{{ $pillar['key'] }}')" data-tab="{{ $pillar['key'] }}"
                class="flex-shrink-0 whitespace-nowrap rounded-xl border px-3 py-2.5 text-xs font-medium transition-all sm:px-4 sm:text-sm"
                :class="activeTab === '{{ $pillar['key'] }}'
                                                                                                    ? 'border-primary/20 bg-white text-primary shadow-sm dark:border-primary-400/30 dark:bg-secondary-800 dark:text-primary-300'
                                                                                                    : 'border-transparent text-neutral-500 hover:bg-white/80 hover:text-secondary-800 dark:text-neutral-400 dark:hover:bg-secondary-700/70 dark:hover:text-neutral-100'">
                {{ $pillar['label'] }}
                <span
                    class="ml-1 sm:ml-1.5 inline-flex items-center rounded-full px-1 py-0.5 text-[9px] font-bold sm:px-1.5 sm:text-[10px] {{ $pillar['bg'] }} {{ $pillar['color'] }}">
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

    {{-- Tab Panels --}}
    <div x-data="plannerChecklist()">
        @foreach($pillars as $pillar)
            <div x-show="activeTab === '{{ $pillar['key'] }}'" x-cloak class="p-5">
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
</div>