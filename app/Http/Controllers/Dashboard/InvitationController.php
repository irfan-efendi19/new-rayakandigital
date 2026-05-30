<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('dashboard');
    }

    public function create(Request $request)
    {
        $selectedTheme = $request->query('theme', 'elegant');
        $themes = Theme::where('is_active', true)->get();

        return view('dashboard.invitations.create', compact('selectedTheme', 'themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'bride_nickname' => 'nullable|string|max:100',
            'groom_nickname' => 'nullable|string|max:100',
            'bride_parents' => 'nullable|string|max:255',
            'groom_parents' => 'nullable|string|max:255',
            'theme' => 'required|string',
        ]);

        $slug = Str::slug($validated['title'] . '-' . Str::random(5));

        $extraData = ['slug' => $slug];
        if ($request->user()->currentTier() === 'free') {
            $demoDays = \App\Models\SystemConfig::first()?->demo_duration_days ?? 3;
            $extraData['trial_started_at'] = now();
            $extraData['expires_at'] = now()->addDays($demoDays);
        }

        $request->user()->invitations()->create(array_merge($validated, $extraData));

        return redirect()->route('dashboard')->with('success', 'Undangan berhasil dibuat! Selanjutnya, lengkapi detail acara Anda.');
    }

    public function show(Invitation $invitation)
    {
        Gate::authorize('view', $invitation);

        $invitation->load(['guests', 'rsvps', 'wishes']);

        return view('dashboard.invitations.show', compact('invitation'));
    }

    public function edit(Invitation $invitation)
    {
        Gate::authorize('update', $invitation);

        return view('dashboard.invitations.edit', compact('invitation'));
    }

    public function update(Request $request, Invitation $invitation)
    {
        Gate::authorize('update', $invitation);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'bride_nickname' => 'nullable|string|max:100',
            'groom_nickname' => 'nullable|string|max:100',
            'bride_parents' => 'nullable|string|max:255',
            'groom_parents' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'event_time' => 'nullable',
            'event_time_end' => 'nullable',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'venue_maps_url' => 'nullable|url',
            'love_story' => 'nullable|string',
            'timezone' => 'nullable|string|max:50',
            'theme' => 'required|string',
            'is_active' => 'boolean',
            'music_url' => 'nullable|string',
        ]);

        // Handle bride photo upload
        if ($request->hasFile('bride_photo')) {
            $validated['bride_photo'] = $request->file('bride_photo')
                ->store('profiles/' . $invitation->id, 'public');
        }

        // Handle groom photo upload
        if ($request->hasFile('groom_photo')) {
            $validated['groom_photo'] = $request->file('groom_photo')
                ->store('profiles/' . $invitation->id, 'public');
        }

        // Handle music upload
        if ($request->hasFile('music_file')) {
            $request->validate(['music_file' => 'file|mimes:mp3,wav,ogg|max:10240']);
            $validated['music_url'] = $request->file('music_file')
                ->store('music/' . $invitation->id, 'public');
        }

        $invitation->update($validated);

        return redirect()->route('dashboard.invitations.show', $invitation)
            ->with('success', 'Undangan berhasil diperbarui.');
    }

    public function destroy(Invitation $invitation)
    {
        Gate::authorize('delete', $invitation);
        $invitation->delete();

        return redirect()->route('dashboard')->with('success', 'Undangan berhasil dihapus.');
    }
}
