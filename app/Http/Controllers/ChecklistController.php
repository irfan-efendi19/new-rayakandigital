<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\WeddingChecklist;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function index(Request $request)
    {
        $invitation = $request->user()->invitation;

        if (! $invitation) {
            return redirect()->route('invitation.create');
        }

        WeddingChecklist::initializePresets($invitation);

        $checklists = $invitation->checklists()
            ->orderBy('category_code')
            ->orderBy('id')
            ->get();

        $totalItems = $checklists->count();
        $completedItems = $checklists->where('is_completed', true)->count();

        $progressPercent = $totalItems > 0
            ? round(($completedItems / $totalItems) * 100)
            : 0;

        $groupedChecklists = $checklists
            ->groupBy('category_code')
            ->sortBy(fn ($items, $code) => array_search($code, array_keys(WeddingChecklist::CATEGORIES), true));

        return view('dashboard.checklist.index', compact(
            'invitation',
            'groupedChecklists',
            'totalItems',
            'completedItems',
            'progressPercent'
        ));
    }

    public function toggle(Request $request, WeddingChecklist $checklist)
    {
        $invitation = $this->invitationForChecklist($request, $checklist);

        $party = $request->input('party');

        if ($checklist->is_document) {
            if ($party === 'pria') {
                $checklist->is_completed_pria = ! $checklist->is_completed_pria;
            } elseif ($party === 'wanita') {
                $checklist->is_completed_wanita = ! $checklist->is_completed_wanita;
            } else {
                abort(422, 'Parameter "party" wajib untuk dokumen persyaratan.');
            }
        } else {
            $checklist->is_completed = ! $checklist->is_completed;
        }

        $checklist->save();

        $allChecklists = $invitation->checklists()->get();

        $totalItems = $allChecklists->sum(fn (WeddingChecklist $item) => $item->checkboxCount());
        $completedItems = $allChecklists->sum(fn (WeddingChecklist $item) => $item->completedCheckboxCount());

        $progressPercent = $totalItems > 0
            ? round(($completedItems / $totalItems) * 100)
            : 0;

        return response()->json([
            'success' => true,
            'is_completed' => $checklist->is_completed,
            'is_completed_pria' => $checklist->is_completed_pria,
            'is_completed_wanita' => $checklist->is_completed_wanita,
            'total_items' => $totalItems,
            'completed_items' => $completedItems,
            'progress_percent' => $progressPercent,
        ]);
    }

    public function store(Request $request)
    {
        $invitation = $request->user()->invitation;

        if (! $invitation) {
            abort(403);
        }

        $validated = $request->validate([
            'category_code' => ['required', 'string', 'in:'.implode(',', array_keys(WeddingChecklist::CATEGORIES))],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $invitation->checklists()->create([
            'category_code' => $validated['category_code'],
            'category_name' => WeddingChecklist::CATEGORIES[$validated['category_code']],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'is_completed' => false,
            'is_preset' => false,
        ]);

        return redirect()->route('dashboard.planner.index')->with('success', 'Checklist custom berhasil ditambahkan.');
    }

    public function update(Request $request, WeddingChecklist $checklist)
    {
        $invitation = $this->invitationForChecklist($request, $checklist);

        if ($checklist->is_preset) {
            abort(403, 'Preset checklist tidak dapat diubah.');
        }

        $validated = $request->validate([
            'category_code' => ['required', 'string', 'in:'.implode(',', array_keys(WeddingChecklist::CATEGORIES))],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $checklist->update([
            'category_code' => $validated['category_code'],
            'category_name' => WeddingChecklist::CATEGORIES[$validated['category_code']],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('dashboard.planner.index')->with('success', 'Checklist custom berhasil diperbarui.');
    }

    public function destroy(Request $request, WeddingChecklist $checklist)
    {
        $this->invitationForChecklist($request, $checklist);

        if ($checklist->is_preset) {
            abort(403, 'Preset checklist tidak dapat dihapus.');
        }

        $checklist->delete();

        return redirect()->route('dashboard.planner.index')->with('success', 'Checklist custom berhasil dihapus.');
    }

    private function invitationForChecklist(Request $request, WeddingChecklist $checklist): Invitation
    {
        $invitation = $request->user()->invitation;

        if (! $invitation || $checklist->invitation_id !== $invitation->id) {
            abort(403);
        }

        return $invitation;
    }
}
