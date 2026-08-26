<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\WeddingChecklist;
use App\Models\WeddingPlannerItem;
use App\Models\WeddingRundown;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WeddingPlannerController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        WeddingPlannerItem::initializePresets($user);

        $plannerItems = WeddingPlannerItem::where('user_id', $user->id)
            ->orderByDesc('event_date')
            ->orderByDesc('created_at')
            ->get();

        $rundowns = WeddingRundown::where('user_id', $user->id)
            ->orderBy('time_start')
            ->get();

        $budgets = $plannerItems->whereIn('category', ['BUDGET', 'VENDOR', 'SESERAHAN', 'ENGAGEMENT', 'PRE_WEDDING']);

        $totalEstimated = $budgets->sum('estimated_cost') + $budgets->sum('cost_pria') + $budgets->sum('cost_wanita');
        $totalPaid = $budgets->sum('paid_amount');

        $vendorItems = $plannerItems->where('category', 'VENDOR');
        $vendorTotalEstimated = $vendorItems->sum('estimated_cost');
        $vendorTotalPaid = $vendorItems->sum('paid_amount');
        $vendorTotalRemaining = max(0, $vendorTotalEstimated - $vendorTotalPaid);

        $itemsByCategory = collect(WeddingPlannerItem::CATEGORIES)->mapWithKeys(
            fn (string $category) => [$category => $plannerItems->where('category', $category)->values()]
        );

        $vendorsByType = collect(WeddingPlannerItem::VENDOR_TYPES)->mapWithKeys(
            fn (string $label, string $type) => [$type => $plannerItems->where('category', 'VENDOR')->where('vendor_type', $type)->values()]
        );

        $invitation = $user->invitation;

        $firstEvent = $invitation?->firstEvent();

        $weddingDate = $firstEvent?->event_date ?? $invitation?->event_date;

        $checklists = collect();
        if ($invitation) {
            WeddingChecklist::initializePresets($invitation);
            $checklists = $invitation->checklists()
                ->orderBy('category_code')
                ->orderBy('id')
                ->get();
        }

        $checklistTotalItems = $checklists->reject(fn (WeddingChecklist $item) => $item->category_code === 'ADMINISTRATION')
            ->sum(fn (WeddingChecklist $item) => $item->checkboxCount());
        $checklistCompletedItems = $checklists->reject(fn (WeddingChecklist $item) => $item->category_code === 'ADMINISTRATION')
            ->sum(fn (WeddingChecklist $item) => $item->completedCheckboxCount());

        $checklistProgressPercent = $checklistTotalItems > 0
            ? round(($checklistCompletedItems / $checklistTotalItems) * 100)
            : 0;

        $checklistsByCategory = collect(WeddingChecklist::CATEGORIES)
            ->map(fn ($label, $code) => $checklists->where('category_code', $code)->values())
            ->reject(fn ($items) => $items->isEmpty());

        return view('dashboard.planner.index', compact(
            'user',
            'plannerItems',
            'rundowns',
            'itemsByCategory',
            'invitation',
            'firstEvent',
            'weddingDate',
            'totalEstimated',
            'totalPaid',
            'vendorTotalRemaining',
            'checklists',
            'checklistTotalItems',
            'checklistCompletedItems',
            'checklistProgressPercent',
            'checklistsByCategory',
            'vendorsByType'
        ));
    }

    public function storeItem(Request $request)
    {
        $validated = $this->validateItem($request);

        WeddingPlannerItem::create([
            'user_id' => $request->user()->id,
            'category' => $validated['category'],
            'subcategory' => $validated['subcategory'] ?? null,
            'vendor_type' => $validated['vendor_type'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'estimated_cost' => $validated['estimated_cost'] ?? 0,
            'actual_cost' => $validated['actual_cost'] ?? 0,
            'paid_amount' => $validated['paid_amount'] ?? 0,
            'cost_pria' => $validated['cost_pria'] ?? 0,
            'cost_wanita' => $validated['cost_wanita'] ?? 0,
            'vendor_contact' => $validated['vendor_contact'] ?? null,
            'event_date' => $validated['event_date'] ?? null,
            'status' => $validated['status'] ?? 'PENDING',
        ]);

        return redirect()->route('dashboard.planner.index')->with('success', 'Item berhasil ditambahkan.');
    }

    public function updateItem(Request $request, WeddingPlannerItem $item)
    {
        abort_unless($item->user_id === $request->user()->id, 403);

        $validated = $this->validateItem($request);

        $item->update([
            'category' => $validated['category'],
            'subcategory' => $validated['subcategory'] ?? $item->subcategory,
            'vendor_type' => $validated['vendor_type'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'estimated_cost' => $validated['estimated_cost'] ?? 0,
            'actual_cost' => $validated['actual_cost'] ?? 0,
            'paid_amount' => $validated['paid_amount'] ?? 0,
            'cost_pria' => $validated['cost_pria'] ?? 0,
            'cost_wanita' => $validated['cost_wanita'] ?? 0,
            'vendor_contact' => $validated['vendor_contact'] ?? null,
            'event_date' => $validated['event_date'] ?? null,
            'status' => $validated['status'] ?? 'PENDING',
        ]);

        return redirect()->route('dashboard.planner.index')->with('success', 'Item berhasil diperbarui.');
    }

    public function destroyItem(Request $request, WeddingPlannerItem $item)
    {
        abort_unless($item->user_id === $request->user()->id, 403);

        $item->delete();

        return redirect()->route('dashboard.planner.index')->with('success', 'Item berhasil dihapus.');
    }

    public function storeRundown(Request $request)
    {
        $validated = $this->validateRundown($request);

        WeddingRundown::create([
            'user_id' => $request->user()->id,
            'time_start' => $validated['time_start'],
            'time_end' => $validated['time_end'] ?? null,
            'activity_name' => $validated['activity_name'],
            'person_in_charge' => $validated['person_in_charge'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('dashboard.planner.index')->with('success', 'Rundown berhasil ditambahkan.');
    }

    public function updateRundown(Request $request, WeddingRundown $rundown)
    {
        abort_unless($rundown->user_id === $request->user()->id, 403);

        $validated = $this->validateRundown($request);

        $rundown->update([
            'time_start' => $validated['time_start'],
            'time_end' => $validated['time_end'] ?? null,
            'activity_name' => $validated['activity_name'],
            'person_in_charge' => $validated['person_in_charge'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('dashboard.planner.index')->with('success', 'Rundown berhasil diperbarui.');
    }

    public function destroyRundown(Request $request, WeddingRundown $rundown)
    {
        abort_unless($rundown->user_id === $request->user()->id, 403);

        $rundown->delete();

        return redirect()->route('dashboard.planner.index')->with('success', 'Rundown berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $data = $this->plannerReportData($request);

        $pdf = Pdf::loadView('dashboard.planner.planner_pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false);

        return $pdf->download('Wedding-Planner-Lengkap-'.$request->user()->id.'-'.$data['generatedAtFilename'].'.pdf');
    }

    private function plannerReportData(Request $request): array
    {
        $user = $request->user();
        WeddingPlannerItem::initializePresets($user);

        $plannerItems = WeddingPlannerItem::whereBelongsTo($user)
            ->orderBy('category')
            ->orderBy('subcategory')
            ->orderBy('id')
            ->get();

        $rundowns = WeddingRundown::whereBelongsTo($user)
            ->orderBy('time_start')
            ->get();

        $invitation = $user->invitation;
        $checklists = collect();

        if ($invitation) {
            WeddingChecklist::initializePresets($invitation);
            $checklists = $invitation->checklists()
                ->orderBy('category_code')
                ->orderBy('id')
                ->get();
        }

        $mainChecklists = $checklists->where('category_code', '!=', 'ADMINISTRATION');
        $administrationItems = $checklists->where('category_code', 'ADMINISTRATION');
        $budgetItems = $plannerItems->where('category', 'BUDGET');
        $vendorItems = $plannerItems->where('category', 'VENDOR');
        $preWeddingItems = $plannerItems->where('category', 'PRE_WEDDING');
        $engagementItems = $plannerItems->where('category', 'ENGAGEMENT');
        $seserahanItems = $plannerItems->where('category', 'SESERAHAN');

        $totalPlanned = $budgetItems->sum('estimated_cost')
            + $vendorItems->sum('estimated_cost')
            + $preWeddingItems->sum('estimated_cost')
            + $engagementItems->sum('cost_pria')
            + $engagementItems->sum('cost_wanita')
            + $seserahanItems->sum('estimated_cost');

        $totalPaid = $budgetItems->sum('paid_amount')
            + $vendorItems->sum('paid_amount')
            + $preWeddingItems->sum('paid_amount');

        $timezone = $invitation?->effectiveTimezone() ?? Invitation::DEFAULT_TIMEZONE;
        $generatedAt = now()->timezone($timezone);

        return [
            'user' => $user,
            'invitation' => $invitation,
            'rundowns' => $rundowns,
            'mainChecklists' => $mainChecklists,
            'administrationItems' => $administrationItems,
            'engagementItems' => $engagementItems,
            'preWeddingItems' => $preWeddingItems,
            'seserahanItems' => $seserahanItems,
            'budgetItems' => $budgetItems,
            'vendorItems' => $vendorItems,
            'checklistTotal' => $mainChecklists->sum(fn (WeddingChecklist $item) => $item->checkboxCount()),
            'checklistCompleted' => $mainChecklists->sum(fn (WeddingChecklist $item) => $item->completedCheckboxCount()),
            'administrationTotal' => $administrationItems->sum(fn (WeddingChecklist $item) => $item->checkboxCount()),
            'administrationCompleted' => $administrationItems->sum(fn (WeddingChecklist $item) => $item->completedCheckboxCount()),
            'totalPlanned' => $totalPlanned,
            'totalPaid' => $totalPaid,
            'totalRemaining' => max(0, $totalPlanned - $totalPaid),
            'generatedAt' => $generatedAt->translatedFormat('d F Y, H:i').' '.Invitation::TIMEZONES[$timezone],
            'generatedAtFilename' => $generatedAt->format('Ymd-His'),
        ];
    }

    private function validateItem(Request $request): array
    {
        $allowedSubcategories = match ($request->input('category')) {
            'SESERAHAN' => array_keys(WeddingPlannerItem::SESERAHAN_PARTIES),
            'BUDGET' => array_keys(WeddingPlannerItem::BUDGET_CATEGORIES),
            'ENGAGEMENT' => array_keys(WeddingPlannerItem::ENGAGEMENT_GROUP_LABELS),
            default => [],
        };

        return $request->validate([
            'category' => ['required', 'string', Rule::in(WeddingPlannerItem::CATEGORIES)],
            'subcategory' => ['nullable', 'string', Rule::in($allowedSubcategories)],
            'vendor_type' => ['nullable', 'string', 'in:'.implode(',', array_keys(WeddingPlannerItem::VENDOR_TYPES))],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'estimated_cost' => ['nullable', 'numeric', 'min:0'],
            'actual_cost' => ['nullable', 'numeric', 'min:0'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'cost_pria' => ['nullable', 'numeric', 'min:0'],
            'cost_wanita' => ['nullable', 'numeric', 'min:0'],
            'vendor_contact' => ['nullable', 'string', 'max:100'],
            'event_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'in:'.implode(',', WeddingPlannerItem::STATUSES)],
        ]);
    }

    private function validateRundown(Request $request): array
    {
        return $request->validate([
            'time_start' => ['required', 'date_format:H:i'],
            'time_end' => ['nullable', 'date_format:H:i', 'after:time_start'],
            'activity_name' => ['required', 'string', 'max:255'],
            'person_in_charge' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
