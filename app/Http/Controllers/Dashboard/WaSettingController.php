<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\PaymentMethodConfig;
use App\Services\FonnteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class WaSettingController extends Controller
{
    /**
     * Display the WhatsApp Gateway setting page for a specific invitation.
     */
    public function index(Request $request, Invitation $invitation): View
    {
        Gate::authorize('update', $invitation);

        if (! $invitation->canUseWhatsappGateway()) {
            abort(403, 'Fitur WhatsApp Gateway hanya tersedia untuk paket Gold ke atas.');
        }

        $waSetting = $invitation->waSetting;

        if (! $waSetting) {
            $waSetting = $invitation->waSetting()->create([
                'user_id' => $invitation->user_id,
                'phone_number' => null,
                'status' => 'PENDING_VERIFICATION',
            ]);
        }

        $adminWa = PaymentMethodConfig::getActive()?->admin_whatsapp_number;

        return view('dashboard.whatsapp.setting', compact('invitation', 'waSetting', 'adminWa'));
    }

    /**
     * Update the sender phone number for a specific invitation.
     */
    public function updatePhone(Request $request, Invitation $invitation): RedirectResponse
    {
        Gate::authorize('update', $invitation);

        $validated = $request->validate([
            'phone_number' => 'required|string|max:20',
        ]);

        $cleanPhone = preg_replace('/[^0-9]/', '', $validated['phone_number']);

        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        } elseif (!str_starts_with($cleanPhone, '62')) {
            $cleanPhone = '62' . $cleanPhone;
        }

        if (strlen($cleanPhone) < 11 || strlen($cleanPhone) > 15) {
            return back()->withErrors(['phone_number' => 'Nomor WhatsApp tidak valid. Minimal 10 digit (contoh: 081234567890).'])->withInput();
        }

        $waSetting = $invitation->waSetting;

        if ($waSetting) {
            $phoneChanged = $waSetting->phone_number !== $cleanPhone;

            $waSetting->update([
                'user_id' => $invitation->user_id,
                'phone_number' => $cleanPhone,
                'status' => $phoneChanged ? 'PENDING_VERIFICATION' : $waSetting->status,
                'fonnte_token' => $phoneChanged ? null : $waSetting->fonnte_token,
                'verified_at' => $phoneChanged ? null : $waSetting->verified_at,
                'admin_notes' => $phoneChanged ? null : $waSetting->admin_notes,
            ]);
        } else {
            $invitation->waSetting()->create([
                'user_id' => $invitation->user_id,
                'phone_number' => $cleanPhone,
                'status' => 'PENDING_VERIFICATION',
            ]);
        }

        return back()->with('success', 'Nomor WhatsApp pengirim untuk undangan ini berhasil disimpan. Harap tunggu verifikasi dari admin.');
    }

    /**
     * Fetch QR Code from Fonnte API for an invitation (only allowed when READY_TO_PAIR / PAIRING).
     */
    public function getQr(Request $request, Invitation $invitation): JsonResponse
    {
        Gate::authorize('update', $invitation);

        $waSetting = $invitation->waSetting;

        if (! $waSetting || ! $waSetting->canPair()) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp pengirim belum diverifikasi oleh admin. Harap tunggu hingga status berubah menjadi "Siap Pairing".',
            ], 422);
        }

        try {
            $fonnteService = app(FonnteService::class);
            $data = $fonnteService->getQrCode($waSetting->fonnte_token);

            if (! empty($data)) {
                $waSetting->update(['status' => 'PAIRING']);

                $url = $data['url'] ?? $data['qr'] ?? null;

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'raw' => $data,
                ]);
            }

            $errorMessage = $data['reason'] ?? $data['message'] ?? 'Gagal mengambil QR Code dari Fonnte.';

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
            ], 400);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan koneksi ke server Fonnte: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check device status for an invitation from Fonnte API.
     */
    public function checkStatus(Request $request, Invitation $invitation): JsonResponse
    {
        Gate::authorize('update', $invitation);

        $waSetting = $invitation->waSetting;

        if (! $waSetting || empty($waSetting->fonnte_token)) {
            return response()->json([
                'status' => $waSetting?->status ?? 'PENDING_VERIFICATION',
                'phone_number' => $waSetting?->phone_number,
                'message' => 'Token belum dikonfigurasi oleh admin.',
            ]);
        }

        try {
            $fonnteService = app(FonnteService::class);
            $data = $fonnteService->checkDeviceStatus($waSetting->fonnte_token);

            if (is_array($data) && ! empty($data)) {
                $deviceStatus = strtoupper($data['device_status'] ?? '');
                $isConnected = in_array($deviceStatus, ['CONNECT', 'CONNECTED'], true);

                $newStatus = match (true) {
                    $isConnected => 'CONNECTED',
                    $waSetting->status === 'PAIRING' => 'PAIRING',
                    default => $waSetting->status,
                };

                $detectedPhone = $data['device'] ?? $data['phone_number'] ?? $data['account'] ?? null;
                $phoneNumber = $detectedPhone ? preg_replace('/[^0-9]/', '', $detectedPhone) : $waSetting->phone_number;

                $waSetting->update([
                    'status' => $newStatus,
                    'phone_number' => $phoneNumber,
                ]);
            }

            return response()->json([
                'status' => $waSetting->status,
                'phone_number' => $waSetting->phone_number,
                'detail' => $data,
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'status' => $waSetting->status,
                'phone_number' => $waSetting->phone_number,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Disconnect device for an invitation.
     */
    public function disconnect(Request $request, Invitation $invitation): RedirectResponse
    {
        Gate::authorize('update', $invitation);

        $waSetting = $invitation->waSetting;

        if ($waSetting) {
            $waSetting->update([
                'status' => 'PENDING_VERIFICATION',
                'verified_at' => null,
            ]);
        }

        return back()->with('success', 'Perangkat berhasil diputus. Admin perlu memverifikasi ulang nomor pengirim ini.');
    }
}
