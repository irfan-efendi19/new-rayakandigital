<x-app-layout>
    <div class="min-h-screen">
        @include('dashboard.planner.partials._hero')

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 space-y-6">
            @include('dashboard.planner.partials._overview')

            @include('dashboard.planner.partials._rundown')

            @php
                $pillars = [
                    ['key' => 'CALENDAR', 'label' => 'Jadwal', 'color' => 'text-blue-600 dark:text-blue-400', 'bg' => 'bg-blue-100 dark:bg-blue-900/40'],
                    ['key' => 'CHECKLIST', 'label' => 'Checklist', 'color' => 'text-emerald-600 dark:text-emerald-400', 'bg' => 'bg-emerald-100 dark:bg-emerald-900/40'],
                    ['key' => 'ENGAGEMENT', 'label' => 'Lamaran', 'color' => 'text-pink-600 dark:text-pink-400', 'bg' => 'bg-pink-100 dark:bg-pink-900/40'],
                    ['key' => 'PRE_WEDDING', 'label' => 'Pre-Wedding', 'color' => 'text-violet-600 dark:text-violet-400', 'bg' => 'bg-violet-100 dark:bg-violet-900/40'],
                    ['key' => 'SESERAHAN', 'label' => 'Seserahan', 'color' => 'text-amber-600 dark:text-amber-400', 'bg' => 'bg-amber-100 dark:bg-amber-900/40'],
                    ['key' => 'ADMINISTRATION', 'label' => 'Administrasi', 'color' => 'text-cyan-600 dark:text-cyan-400', 'bg' => 'bg-cyan-100 dark:bg-cyan-900/40'],
                    ['key' => 'BUDGET', 'label' => 'Budget', 'color' => 'text-green-600 dark:text-green-400', 'bg' => 'bg-green-100 dark:bg-green-900/40'],
                    ['key' => 'VENDOR', 'label' => 'Vendor', 'color' => 'text-orange-600 dark:text-orange-400', 'bg' => 'bg-orange-100 dark:bg-orange-900/40'],
                ];

                $statusStyles = [
                    'PENDING' => 'bg-neutral-100 text-neutral-600 dark:bg-neutral-700 dark:text-neutral-300',
                    'IN_PROGRESS' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300',
                    'COMPLETED' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300',
                    'CANCELLED' => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300',
                ];

                $statusLabels = [
                    'PENDING' => 'Pending',
                    'IN_PROGRESS' => 'Proses',
                    'COMPLETED' => 'Selesai',
                    'CANCELLED' => 'Batal',
                ];

                $statusOptions = [
                    'PENDING',
                    'IN_PROGRESS',
                    'COMPLETED',
                    'CANCELLED',
                ];

                $adminChecklists = $checklists->where('category_code', 'ADMINISTRATION');
                $adminTotalItems = $adminChecklists->sum(fn($item) => $item->checkboxCount());
                $adminCompletedItems = $adminChecklists->sum(fn($item) => $item->completedCheckboxCount());
            @endphp

            @include('dashboard.planner.partials._pillars')
        </div>
    </div>

    @include('dashboard.planner.partials.modals._items')
    @include('dashboard.planner.partials.modals._planner')
    @include('dashboard.planner.partials.modals._rundowns')

    @include('dashboard.planner.partials._scripts')
</x-app-layout>