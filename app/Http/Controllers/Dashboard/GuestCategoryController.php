<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GuestCategory;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GuestCategoryController extends Controller
{
    public function index(Invitation $invitation)
    {
        Gate::authorize('view', $invitation);

        $categories = $invitation->guestCategories()->latest()->get();

        return response()->json($categories);
    }

    public function store(Request $request, Invitation $invitation)
    {
        Gate::authorize('update', $invitation);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:7',
        ]);

        $category = $invitation->guestCategories()->create([
            'name' => $validated['name'],
            'color_code' => $validated['color_code'] ?? '#6b7280',
        ]);

        return response()->json($category, 201);
    }

    public function update(Request $request, Invitation $invitation, GuestCategory $guestCategory)
    {
        Gate::authorize('update', $invitation);

        if ($guestCategory->invitation_id !== $invitation->id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:7',
        ]);

        $guestCategory->update($validated);

        return response()->json($guestCategory);
    }

    public function destroy(Invitation $invitation, GuestCategory $guestCategory)
    {
        Gate::authorize('update', $invitation);

        if ($guestCategory->invitation_id !== $invitation->id) {
            abort(404);
        }

        $guestCategory->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus.']);
    }
}
