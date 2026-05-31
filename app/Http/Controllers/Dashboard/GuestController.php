<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GuestController extends Controller
{
    public function index(Invitation $invitation)
    {
        Gate::authorize('view', $invitation);

        $guests = $invitation->guests()
            ->with(['whatsappLogs' => fn ($q) => $q->latest()])
            ->latest()
            ->paginate(20);

        return view('dashboard.guests.index', compact('invitation', 'guests'));
    }

    public function create(Invitation $invitation)
    {
        Gate::authorize('update', $invitation);

        return view('dashboard.guests.create', compact('invitation'));
    }

    public function store(Request $request, Invitation $invitation)
    {
        Gate::authorize('update', $invitation);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $invitation->guests()->create($validated);

        return redirect()->route('dashboard.invitations.guests.index', $invitation)
            ->with('success', 'Tamu berhasil ditambahkan.');
    }

    public function edit(Invitation $invitation, Guest $guest)
    {
        Gate::authorize('update', $invitation);

        return view('dashboard.guests.edit', compact('invitation', 'guest'));
    }

    public function update(Request $request, Invitation $invitation, Guest $guest)
    {
        Gate::authorize('update', $invitation);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $guest->update($validated);

        return redirect()->route('dashboard.invitations.guests.index', $invitation)
            ->with('success', 'Data tamu berhasil diperbarui.');
    }

    public function destroy(Invitation $invitation, Guest $guest)
    {
        Gate::authorize('update', $invitation);
        $guest->delete();

        return redirect()->route('dashboard.invitations.guests.index', $invitation)
            ->with('success', 'Tamu berhasil dihapus.');
    }

    public function import(Request $request, Invitation $invitation, \App\Services\GuestImportService $importService)
    {
        Gate::authorize('update', $invitation);

        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120',
        ]);

        $result = $importService->import($invitation, $request->file('file'));

        $message = "Berhasil import {$result['imported']} tamu.";
        if ($result['skipped'] > 0) {
            $message .= " {$result['skipped']} tamu dilewati.";
        }

        return redirect()->route('dashboard.invitations.guests.index', $invitation)
            ->with('success', $message)
            ->with('import_errors', $result['errors']);
    }
}
