<?php

namespace App\Http\Controllers;

use App\Models\WeddingChecklist;
use App\Models\WeddingPlannerItem;
use App\Models\WeddingRundown;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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
        $userId = $request->user()->id;

        $rundowns = WeddingRundown::where('user_id', $userId)
            ->orderBy('time_start')
            ->get();

        $budgets = WeddingPlannerItem::where('user_id', $userId)
            ->whereIn('category', ['BUDGET', 'VENDOR'])
            ->orderByDesc('event_date')
            ->get();

        $data = [
            'user' => $request->user(),
            'rundowns' => $rundowns,
            'budgets' => $budgets,
            'totalEstimated' => $budgets->sum('estimated_cost'),
            'totalActual' => $budgets->sum('actual_cost'),
            'totalPaid' => $budgets->sum('paid_amount'),
            'generatedAt' => now()->translatedFormat('d F Y, H:i'),
        ];

        $pdf = Pdf::loadView('dashboard.planner.planner_pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false);

        return $pdf->download('Wedding-Planner-Rundown-Budget-'.$userId.'-'.now()->format('Ymd-His').'.pdf');
    }

    private function validateItem(Request $request): array
    {
        return $request->validate([
            'category' => ['required', 'string', 'in:'.implode(',', WeddingPlannerItem::CATEGORIES)],
            'subcategory' => ['nullable', 'string', 'in:PRIA,WANITA'],
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
