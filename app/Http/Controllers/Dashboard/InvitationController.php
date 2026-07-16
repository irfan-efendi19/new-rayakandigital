<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\InvitationEvent;
use App\Models\InvitationStory;
use App\Models\SystemConfig;
use App\Models\Theme;
use App\Services\ImageCompressionService;
use App\Services\QrWithLogoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class InvitationController extends Controller
{
    const RESERVED_SLUGS = [
        'semua-tema', 'undangan-web', 'buku-tamu', 'live-streaming',
        'syarat-ketentuan', 'kebijakan-privasi', 'tentang-kami', 'hubungi-kami',
        'auth', 'dashboard', 'profile', 'payments', 'invitations',
        'register', 'login', 'forgot-password', 'reset-password',
        'verify-email', 'email', 'confirm-password', 'password', 'logout',
        'home', 'preview', 'storage', 'css', 'js', 'api',
    ];
    public function index(Request $request)
    {
        return redirect()->route('dashboard');
    }

    public function create(Request $request)
    {
        $hasPredefinedTheme = $request->has('theme');
        $selectedTheme = $request->query('theme', 'elegant');
        $themes = Theme::where('is_active', true)->with('themeCategory')->get();

        return view('dashboard.invitations.create', compact('selectedTheme', 'themes', 'hasPredefinedTheme'));
    }

    public function store(Request $request, ImageCompressionService $compressor)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:100|regex:/^[a-z0-9\-]+$/',
            'bride_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'bride_nickname' => 'nullable|string|max:100',
            'groom_nickname' => 'nullable|string|max:100',
            'bride_father_name' => 'nullable|string|max:255',
            'bride_mother_name' => 'nullable|string|max:255',
            'groom_father_name' => 'nullable|string|max:255',
            'groom_mother_name' => 'nullable|string|max:255',
            'theme' => 'required|string',
            'timezone' => 'nullable|string|max:50',
            'bride_groom_order' => 'nullable|in:male_first,female_first',
            'events' => 'nullable|array',
            'events.*.event_title' => 'required_with:events|string|max:100',
            'events.*.event_date' => 'required_with:events|date',
            'events.*.start_time' => 'required_with:events',
            'events.*.end_time' => 'nullable',
            'events.*.is_until_finished' => 'nullable|boolean',
            'events.*.place_name' => 'required_with:events|string|max:150',
            'events.*.place_address' => 'required_with:events|string',
            'events.*.google_maps_url' => 'nullable|url',
        ]);

        // Handle slug
        $newSlug = $request->filled('slug') ? trim($request->slug) : null;
        if ($newSlug) {
            if (in_array($newSlug, self::RESERVED_SLUGS)) {
                return back()->withErrors(['slug' => 'Tautan "' . $newSlug . '" tidak tersedia. Silakan gunakan tautan kustom lain.'])->withInput();
            }
            $exists = Invitation::where('slug', $newSlug)->exists();
            if ($exists) {
                return back()->withErrors(['slug' => 'Tautan sudah digunakan oleh undangan lain.'])->withInput();
            }
            $validated['slug'] = $newSlug;
        } else {
            $validated['slug'] = Str::slug($validated['title'].'-'.Str::random(5));
        }

        $demoDays = SystemConfig::first()?->demo_duration_days ?? 3;
        $extraData = [
            'trial_started_at' => now(),
            'expires_at' => now()->addDays($demoDays),
        ];

        $invitation = $request->user()->invitations()->create(array_merge($validated, $extraData));

        // Handle bride photo
        if ($request->hasFile('bride_photo')) {
            $invitation->update([
                'bride_photo' => $compressor->compress(
                    $request->file('bride_photo'),
                    'profiles/'.$invitation->id
                ),
            ]);
        }

        // Handle groom photo
        if ($request->hasFile('groom_photo')) {
            $invitation->update([
                'groom_photo' => $compressor->compress(
                    $request->file('groom_photo'),
                    'profiles/'.$invitation->id
                ),
            ]);
        }

        // Handle cover photo
        if ($request->hasFile('cover_photo')) {
            $invitation->update([
                'cover_photo' => $compressor->compress(
                    $request->file('cover_photo'),
                    'cover/'.$invitation->id
                ),
            ]);
        }

        // Handle events
        if ($request->has('events')) {
            foreach (array_values($request->input('events', [])) as $index => $eventData) {
                $eventData['sort_order'] = $index;
                $eventData['is_until_finished'] = $eventData['is_until_finished'] ?? false;
                $invitation->events()->create($eventData);
            }
        }

        // Handle gallery photos
        if ($request->hasFile('photos')) {
            $uploaded = [];
            foreach ($request->file('photos') as $photo) {
                $uploaded[] = $compressor->compress($photo, 'gallery/'.$invitation->id);
            }
            if (! empty($uploaded)) {
                $existing = $invitation->gallery_photos ?? [];
                $invitation->update(['gallery_photos' => array_merge($existing, $uploaded)]);
            }
        }

        return redirect()->route('dashboard.invitations.show', $invitation)
            ->with('success', 'Undangan berhasil dibuat! Selanjutnya, lengkapi detail acara Anda.');
    }

    public function show(Invitation $invitation)
    {
        Gate::authorize('view', $invitation);
        $invitation->load(['guests', 'rsvps', 'wishes']);

        $pageViews = $invitation->pageViews()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total, COUNT(DISTINCT visitor_id) as unique_visitors')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = [];
        $chartTotals = [];
        $chartUniques = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayData = $pageViews->firstWhere('date', $date);
            $chartLabels[] = now()->subDays($i)->translatedFormat('d M');
            $chartTotals[] = $dayData?->total ?? 0;
            $chartUniques[] = $dayData?->unique_visitors ?? 0;
        }

        $totalViews = array_sum($chartTotals);
        $totalUniques = $invitation->pageViews()
            ->whereNotNull('visitor_id')
            ->selectRaw('COUNT(DISTINCT visitor_id) as count')
            ->value('count') ?? 0;

        $rsvpData = $invitation->rsvps->map(fn($rsvp) => [
            'id' => $rsvp->id,
            'guest_name' => $rsvp->guest_name,
            'attendance' => $rsvp->attendance,
            'attendance_label' => $rsvp->attendanceLabel(),
            'pax' => (string) $rsvp->pax,
            'created_at' => $rsvp->created_at->format('d/m/Y H:i'),
            'updated_at' => $rsvp->updated_at->format('d/m/Y H:i'),
        ])->values();

        if ($invitation->hasFeature('qr_rsvp_universal')) {
            $rsvpUrl = url('/') . '/' . $invitation->slug . '?mode=scan_qr';

            $qrData = app(QrWithLogoService::class)->generate($rsvpUrl);
            $qrCodeData = $qrData['data'];

            $qrStats = [
                'total_pax_hadir' => $invitation->rsvps()->where('attendance', 'attending')->sum('pax'),
                'total_tamu_respon' => $invitation->rsvps()->count(),
                'tamu_hadir' => $invitation->rsvps()->where('attendance', 'attending')->count(),
                'tamu_absen' => $invitation->rsvps()->where('attendance', 'not_attending')->count(),
                'tamu_ragu' => $invitation->rsvps()->where('attendance', 'uncertain')->count(),
            ];
        } else {
            $qrCodeData = null;
            $rsvpUrl = null;
            $qrStats = null;
        }

        $guestsData = $invitation->guests->map(fn($guest) => [
            'id' => $guest->id,
            'name' => $guest->name,
            'attendance_status' => $guest->attendance_status,
            'phone' => $guest->phone ?? $guest->whatsapp_number ?? '-',
            'checked_in_at' => $guest->checked_in_at?->format('d/m/Y H:i') ?? '-',
            'created_at' => $guest->created_at->format('d/m/Y H:i'),
        ])->values();

        $wishesData = $invitation->wishes->map(fn($wish) => [
            'id' => $wish->id,
            'guest_name' => $wish->guest_name,
            'message' => $wish->message,
            'created_at' => $wish->created_at->format('d/m/Y H:i'),
            'created_at_diff' => $wish->created_at->diffForHumans(),
        ])->values();

        return view('dashboard.invitations.show', compact(
            'invitation', 'chartLabels', 'chartTotals', 'chartUniques', 'totalViews', 'totalUniques', 'rsvpData', 'qrCodeData', 'rsvpUrl', 'qrStats', 'guestsData', 'wishesData'
        ));
    }

    public function edit(Invitation $invitation)
    {
        Gate::authorize('update', $invitation);
        $invitation->load(['events', 'stories', 'screenGalleries']);

        $themes = Theme::where('is_active', true)->with('themeCategory')->get();

        return view('dashboard.invitations.edit', compact('invitation', 'themes'));
    }

    public function qrRsvp(Invitation $invitation)
    {
        Gate::authorize('view', $invitation);

        if (! $invitation->hasFeature('qr_rsvp_universal')) {
            abort(403, 'Fitur QR RSVP Universal hanya tersedia untuk paket Gold dan Platinum.');
        }

        $invitation->load(['rsvps']);

        $rsvpUrl = url('/') . '/' . $invitation->slug . '?mode=scan_qr';

        $qrData = app(QrWithLogoService::class)->generate($rsvpUrl);
        $qrCodeData = $qrData['data'];

        $report = [
            'total_pax_hadir' => $invitation->rsvps()->where('attendance', 'attending')->sum('pax'),
            'total_tamu_respon' => $invitation->rsvps()->count(),
            'tamu_hadir' => $invitation->rsvps()->where('attendance', 'attending')->count(),
            'tamu_absen' => $invitation->rsvps()->where('attendance', 'not_attending')->count(),
            'tamu_ragu' => $invitation->rsvps()->where('attendance', 'uncertain')->count(),
        ];

        return view('dashboard.invitations.qr-rsvp', compact('invitation', 'qrCodeData', 'rsvpUrl', 'report'));
    }

    public function checkSlug(Request $request)
    {
        $slug = $request->query('slug');

        if (in_array($slug, self::RESERVED_SLUGS)) {
            return response()->json(['available' => false, 'message' => 'Tautan ini tidak tersedia karena bentrok dengan halaman web.']);
        }

        $excludeId = $request->query('exclude');

        $query = Invitation::where('slug', $slug);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $exists = $query->exists();

        return response()->json(['available' => ! $exists]);
    }

    public function update(Request $request, Invitation $invitation, ImageCompressionService $compressor)
    {
        Gate::authorize('update', $invitation);

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:100|regex:/^[a-z0-9\-]+$/',
                'bride_name' => 'required|string|max:255',
                'groom_name' => 'required|string|max:255',
                'bride_nickname' => 'nullable|string|max:100',
                'groom_nickname' => 'nullable|string|max:100',
                'bride_father_name' => 'nullable|string|max:255',
                'bride_mother_name' => 'nullable|string|max:255',
                'groom_father_name' => 'nullable|string|max:255',
                'groom_mother_name' => 'nullable|string|max:255',
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
                'quote_content' => 'nullable|string',
                'quote_source' => 'nullable|string|max:150',
                'show_qr_checkin' => 'boolean',
                'show_comments' => 'boolean',
                'show_rsvp' => 'boolean',
                'is_rsvp_pax_limited' => 'boolean',
                'max_global_pax_quota' => 'nullable|integer|min:1',
                'max_pax_per_guest' => 'integer|min:1|max:50',
                'show_gallery' => 'boolean',
                'show_gift' => 'boolean',
                'show_stories' => 'boolean',
                'show_countdown' => 'boolean',
                'show_event_detail' => 'boolean',
                'show_quote' => 'boolean',
                'show_video' => 'boolean',
                'youtube_url' => 'nullable|string|max:255',
                'screen_bride_names' => 'nullable|string|max:255',
                'screen_overlay_opacity' => 'nullable|integer|min:0|max:100',
                'bride_groom_order' => 'nullable|in:male_first,female_first',
            ]);
        } catch (ValidationException $e) {
            throw $e;
        }

        // Handle bride photo upload
        if ($request->hasFile('bride_photo')) {
            $validated['bride_photo'] = $compressor->compress(
                $request->file('bride_photo'),
                'profiles/'.$invitation->id
            );
        }

        // Handle groom photo upload
        if ($request->hasFile('groom_photo')) {
            $validated['groom_photo'] = $compressor->compress(
                $request->file('groom_photo'),
                'profiles/'.$invitation->id
            );
        }

        // Handle cover photo upload
        if ($request->hasFile('cover_photo')) {
            $validated['cover_photo'] = $compressor->compress(
                $request->file('cover_photo'),
                'cover/'.$invitation->id
            );
        }

        // Handle music upload
        if ($request->hasFile('music_file')) {
            $request->validate(['music_file' => 'file|mimes:mp3,wav,ogg|max:10240']);
            $validated['music_url'] = $request->file('music_file')
                ->store('music/'.$invitation->id, 'public');
        }

        // Handle screen background upload
        if ($request->hasFile('screen_background_image')) {
            if ($invitation->screen_background_image) {
                Storage::disk('public')->delete($invitation->screen_background_image);
            }
            $validated['screen_background_image'] = $compressor->compress(
                $request->file('screen_background_image'),
                'screen-bg/'.$invitation->id
            );
        }

        // Handle slug update
        $newSlug = $request->filled('slug') ? trim($request->slug) : null;

        if ($newSlug && $newSlug !== $invitation->slug) {
            // Check if slug conflicts with existing routes
            if (in_array($newSlug, self::RESERVED_SLUGS)) {
                return back()->withErrors(['slug' => 'Tautan "' . $newSlug . '" tidak tersedia. Silakan gunakan tautan kustom lain.'])->withInput();
            }

            $exists = Invitation::where('slug', $newSlug)
                ->where('id', '!=', $invitation->id)
                ->exists();

            if ($exists) {
                return back()->withErrors(['slug' => 'Tautan sudah digunakan oleh undangan lain.'])->withInput();
            }

            // Update slug and increment change counter
            $validated['slug'] = $newSlug;
            if (Schema::hasColumn('invitations', 'slug_change_count')) {
                $validated['slug_change_count'] = ($invitation->slug_change_count ?? 0) + 1;
            }
        } else {
            unset($validated['slug']);
        }

        // Handle YouTube URL & auto-extract video ID
        if ($request->filled('youtube_url')) {
            $validated['youtube_url'] = $request->youtube_url;
            $validated['youtube_video_id'] = Invitation::extractYoutubeId($request->youtube_url);
        } else {
            $validated['youtube_url'] = null;
            $validated['youtube_video_id'] = null;
        }

        $invitation->update(array_merge($validated, ['is_active' => true]));

        // Handle events upsert
        if ($request->has('events_enabled')) {
            $request->validate([
                'events' => 'array',
                'events.*.id' => 'nullable|integer|exists:invitation_events,id',
                'events.*.event_title' => 'required|string|max:100',
                'events.*.event_date' => 'required|date',
                'events.*.start_time' => 'required',
                'events.*.end_time' => 'nullable',
                'events.*.is_until_finished' => 'nullable|boolean',
                'events.*.place_name' => 'required|string|max:150',
                'events.*.place_address' => 'required|string',
                'events.*.google_maps_url' => 'nullable|url',
            ]);

            $submittedIds = [];
            foreach (array_values($request->input('events', [])) as $index => $eventData) {
                $eventData['sort_order'] = $index;
                $eventData['is_until_finished'] = $eventData['is_until_finished'] ?? false;

                if (! empty($eventData['id'])) {
                    $event = InvitationEvent::where('invitation_id', $invitation->id)
                        ->where('id', $eventData['id'])
                        ->firstOrFail();
                    $event->update($eventData);
                    $submittedIds[] = $event->id;
                } else {
                    unset($eventData['id']);
                    $event = $invitation->events()->create($eventData);
                    $submittedIds[] = $event->id;
                }
            }

            $invitation->events()->whereNotIn('id', $submittedIds)->delete();
        }

        // Handle stories upsert
        if ($request->has('stories')) {
            $request->validate([
                'stories' => 'nullable|array',
                'stories.*.id' => 'nullable|integer|exists:invitation_stories,id',
                'stories.*.story_date' => 'required|string|max:255',
                'stories.*.story_title' => 'nullable|string|max:255',
                'stories.*.story_description' => 'required|string',
            ]);

            $submittedStoryIds = [];
            foreach (array_values($request->input('stories', [])) as $index => $storyData) {
                $storyData['order_position'] = $index;

                if (! empty($storyData['id'])) {
                    $story = InvitationStory::where('invitation_id', $invitation->id)
                        ->where('id', $storyData['id'])
                        ->firstOrFail();
                    $story->update($storyData);
                    $submittedStoryIds[] = $story->id;
                } else {
                    unset($storyData['id']);
                    $story = $invitation->stories()->create($storyData);
                    $submittedStoryIds[] = $story->id;
                }
            }

            $invitation->stories()->whereNotIn('id', $submittedStoryIds)->delete();
        }

        return redirect()->route('dashboard.invitations.show', $invitation)
            ->with('success', 'Undangan berhasil diperbarui.');
    }

    public function rsvpReport(Invitation $invitation)
    {
        Gate::authorize('view', $invitation);

        $totalPaxHadir = $invitation->rsvps()->where('attendance', 'attending')->sum('pax');
        $totalTamuRespon = $invitation->rsvps()->count();
        $tamuHadir = $invitation->rsvps()->where('attendance', 'attending')->count();
        $tamuAbsen = $invitation->rsvps()->where('attendance', 'not_attending')->count();
        $tamuRagu = $invitation->rsvps()->where('attendance', 'uncertain')->count();

        $paxPercentage = 0;
        if ($invitation->isRsvpPaxLimited() && $invitation->max_global_pax_quota > 0) {
            $paxPercentage = min(100, round(($totalPaxHadir / $invitation->max_global_pax_quota) * 100));
        }

        return response()->json([
            'total_pax_hadir' => $totalPaxHadir,
            'total_tamu_respon' => $totalTamuRespon,
            'tamu_hadir' => $tamuHadir,
            'tamu_absen' => $tamuAbsen,
            'tamu_ragu' => $tamuRagu,
            'pax_percentage' => $paxPercentage,
        ]);
    }

    public function destroy(Invitation $invitation)
    {
        Gate::authorize('delete', $invitation);
        $invitation->delete();

        return redirect()->route('dashboard')->with('success', 'Undangan berhasil dihapus.');
    }
}
