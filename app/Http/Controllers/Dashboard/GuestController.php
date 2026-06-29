<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\GuestTemplateExport;
use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class GuestController extends Controller
{
    private function authorizePersonalLink(Invitation $invitation): void
    {
        Gate::authorize('view', $invitation);

        if (!$invitation->hasFeature('personal_link')) {
            abort(403, 'Fitur manajemen tamu tidak tersedia pada paket Anda.');
        }
    }

    public function index(Request $request, Invitation $invitation)
    {
        $this->authorizePersonalLink($invitation);

        $search = $request->input('search');
        $perPage = $request->input('per_page', 20);

        $perPage = in_array($perPage, [10, 20, 50, 100, 'all']) ? $perPage : 20;

        $query = $invitation->guests()
            ->with(['whatsappLogs' => fn ($q) => $q->latest(), 'guestCategory', 'events', 'invitation']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('whatsapp_number', 'like', "%{$search}%")
                  ->orWhereHas('guestCategory', fn ($cq) => $cq->where('name', 'like', "%{$search}%"));
            });
        }

        $guests = $perPage === 'all'
            ? $query->latest()->get()
            : $query->latest()->paginate((int) $perPage);

        $categories = $invitation->guestCategories()->get();

        $presets = [
            [
                'name' => 'Gaya Formal / Umum',
                'text' => "Kepada Yth.\nBapak/Ibu/Saudara/i {{nama_tamu}}\n\nSalam hormat,\nDengan memohon rahmat dan ridho Allah SWT, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara resepsi pernikahan kami, yang detail undangannya dapat diakses via tautan di bawah ini:\n\n{{link_undangan}}\n\nMerupakan suatu kebahagiaan dan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu kepada kedua mempelai.\n\nTerima kasih.\nKami yang berbahagia,\n{{nama_pengantin}}",
            ],
            [
                'name' => 'Gaya Islami / Religius',
                'text' => "Assalamualaikum Warahmatullahi Wabarakatuh\n\nTanpa mengurangi rasa hormat, izinkan kami mengundang Bapak/Ibu/Saudara/i {{nama_tamu}} untuk menghadiri acara pernikahan kami.\n\nDan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya (QS. Ar-Rum: 21).\n\nInformasi lengkap mengenai waktu dan lokasi acara dapat dilihat melalui link undangan digital berikut:\n{{link_undangan}}\n\nUngkapan terima kasih yang tulus kami haturkan atas kehadiran dan doa restu Anda.\n\nWassalamualaikum Warahmatullahi Wabarakatuh\n\nKami yang berbahagia,\n{{nama_pengantin}}",
            ],
            [
                'name' => 'Gaya Kasual / Teman',
                'text' => "Halo {{nama_tamu}}!\n\nKabar bahagia nih, kami mau melangsungkan pernikahan! Tanpa mengurangi rasa hormat, lewat pesan ini kami ingin mengundang kamu untuk hadir di hari bahagia kami.\n\nYuk, intip detail acara, lokasi map, dan isi buku tamu lewat link undangan digital di bawah ini:\n{{link_undangan}}\n\nDatang ya! Kehadiran dan doa restu dari kamu berharga banget buat kami berdua.\n\nSampai jumpa di lokasi!\nWarm regards,\n{{nama_pengantin}}",
            ],
            [
                'name' => 'Gaya Singkat / Minimalis',
                'text' => "Halo {{nama_tamu}},\n\nKami mengundang Anda untuk menghadiri acara pernikahan {{nama_pengantin}}.\n\nDetail informasi acara (Waktu, Tempat, & Protokol) dapat diakses langsung melalui tautan undangan digital resmi berikut:\n{{link_undangan}}\n\nTerima kasih atas perhatian dan doa restu terbaik Anda.",
            ],
        ];

        return view('dashboard.guests.index', compact('invitation', 'guests', 'presets', 'categories'));
    }

    public function create(Invitation $invitation)
    {
        $this->authorizePersonalLink($invitation);
        Gate::authorize('update', $invitation);

        $categories = $invitation->guestCategories()->get();
        $events = $invitation->events()->orderBy('sort_order')->get();

        return view('dashboard.guests.create', compact('invitation', 'categories', 'events'));
    }

    public function store(Request $request, Invitation $invitation)
    {
        $this->authorizePersonalLink($invitation);
        Gate::authorize('update', $invitation);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'guest_category_id' => 'nullable|exists:guest_categories,id',
            'event_ids' => 'nullable|array',
            'event_ids.*' => 'exists:invitation_events,id',
        ]);

        $guest = $invitation->guests()->create($validated);

        $guest->events()->sync($request->input('event_ids', []));

        return redirect()->route('dashboard.invitations.guests.index', $invitation)
            ->with('success', 'Tamu berhasil ditambahkan.');
    }

    public function edit(Invitation $invitation, Guest $guest)
    {
        $this->authorizePersonalLink($invitation);
        Gate::authorize('update', $invitation);

        $categories = $invitation->guestCategories()->get();
        $events = $invitation->events()->orderBy('sort_order')->get();
        $guest->load('events');

        return view('dashboard.guests.edit', compact('invitation', 'guest', 'categories', 'events'));
    }

    public function update(Request $request, Invitation $invitation, Guest $guest)
    {
        $this->authorizePersonalLink($invitation);
        Gate::authorize('update', $invitation);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'guest_category_id' => 'nullable|exists:guest_categories,id',
            'event_ids' => 'nullable|array',
            'event_ids.*' => 'exists:invitation_events,id',
        ]);

        $guest->update($validated);

        $guest->events()->sync($request->input('event_ids', []));

        return redirect()->route('dashboard.invitations.guests.index', $invitation)
            ->with('success', 'Data tamu berhasil diperbarui.');
    }

    public function destroy(Invitation $invitation, Guest $guest)
    {
        $this->authorizePersonalLink($invitation);
        Gate::authorize('update', $invitation);
        $guest->delete();

        return redirect()->route('dashboard.invitations.guests.index', $invitation)
            ->with('success', 'Tamu berhasil dihapus.');
    }

    public function destroySelected(Request $request, Invitation $invitation)
    {
        $this->authorizePersonalLink($invitation);
        Gate::authorize('update', $invitation);

        $validated = $request->validate([
            'guest_ids' => 'required|array',
            'guest_ids.*' => 'exists:guests,id',
        ]);

        $deleted = $invitation->guests()
            ->whereIn('id', $validated['guest_ids'])
            ->delete();

        return redirect()->route('dashboard.invitations.guests.index', $invitation)
            ->with('success', "{$deleted} tamu berhasil dihapus.");
    }

    public function destroyAll(Invitation $invitation)
    {
        $this->authorizePersonalLink($invitation);
        Gate::authorize('update', $invitation);

        $deleted = $invitation->guests()->delete();

        return redirect()->route('dashboard.invitations.guests.index', $invitation)
            ->with('success', "Semua {$deleted} tamu berhasil dihapus.");
    }

    public function downloadTemplate(Invitation $invitation)
    {
        $this->authorizePersonalLink($invitation);

        return Excel::download(new GuestTemplateExport, 'template-import-tamu.xlsx');
    }

    public function import(Request $request, Invitation $invitation, \App\Services\GuestImportService $importService)
    {
        $this->authorizePersonalLink($invitation);
        Gate::authorize('update', $invitation);

        if (!$invitation->hasFeature('guest_import')) {
            abort(403, 'Fitur import tamu tidak tersedia pada paket Anda.');
        }

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
