<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\AffiliatePayout;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AffiliatePayoutService
{
    public function __construct(private AffiliateService $affiliates) {}

    public function request(Affiliate $affiliate, int $amount): AffiliatePayout
    {
        return $this->createRequest($affiliate, $amount);
    }

    public function requestAll(Affiliate $affiliate): AffiliatePayout
    {
        return $this->createRequest($affiliate);
    }

    private function createRequest(Affiliate $affiliate, ?int $amount = null): AffiliatePayout
    {
        return DB::transaction(function () use ($affiliate, $amount) {
            $affiliate = Affiliate::query()->eligible()->lockForUpdate()->findOrFail($affiliate->id);
            $balance = $this->affiliates->balance($affiliate);
            $amount ??= $balance['available'];

            if ($amount < $this->affiliates->settings()['minimum_payout'] || $amount > $balance['available']) {
                throw ValidationException::withMessages(['amount' => 'Nominal harus memenuhi minimum pencairan dan tidak melebihi saldo siap cair.']);
            }

            return $affiliate->payouts()->create([
                'amount' => $amount, 'bank_name' => $affiliate->bank_name,
                'bank_account_number' => $affiliate->bank_account_number,
                'bank_account_holder' => $affiliate->bank_account_holder,
            ]);
        }, 3);
    }

    public function process(AffiliatePayout $payout, User $admin, string $status, ?string $note = null, ?string $reference = null): void
    {
        abort_unless($admin->isAdmin() && ! $admin->is_banned, 403);
        DB::transaction(function () use ($payout, $admin, $status, $note, $reference) {
            $affiliate = Affiliate::query()->lockForUpdate()->findOrFail($payout->affiliate_id);
            $payout = AffiliatePayout::query()->lockForUpdate()->findOrFail($payout->id);
            $allowed = ['pending' => ['approved', 'rejected'], 'approved' => ['paid', 'rejected']];
            if (! in_array($status, $allowed[$payout->status] ?? [])) {
                throw ValidationException::withMessages(['status' => 'Status pencairan sudah berubah. Muat ulang halaman.']);
            }
            if ($status !== 'rejected' && (! Affiliate::query()->eligible()->whereKey($affiliate)->exists()
                || $this->affiliates->balance($affiliate)['available'] < 0)) {
                throw ValidationException::withMessages(['status' => 'Mitra tidak aktif atau saldo perlu diperiksa sebelum pencairan.']);
            }
            if ($status === 'rejected' && blank($note)) {
                throw ValidationException::withMessages(['review_note' => 'Alasan penolakan wajib diisi.']);
            }
            if ($status === 'paid' && (blank($reference) || mb_strlen($reference) > 150
                || AffiliatePayout::where('transfer_reference', $reference)->exists())) {
                throw ValidationException::withMessages(['transfer_reference' => 'Masukkan referensi transfer yang unik dan valid.']);
            }

            $payout->update([
                'status' => $status, 'review_note' => $note, 'processed_by' => $admin->id,
                'transfer_reference' => $status === 'paid' ? $reference : null,
                'paid_at' => $status === 'paid' ? now() : null,
            ]);
        }, 3);
    }
}
