<?php

namespace App\Filament\Resources\AddonTransactions;

use App\Models\AddonTransaction;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class AddonTransactionActions
{
    public static function confirmAndActivate(AddonTransaction $transaction): void
    {
        DB::beginTransaction();

        try {
            $transaction->update([
                'payment_status' => 'settlement',
                'paid_at' => now(),
            ]);

            $transaction->addon->invitations()->syncWithoutDetaching([
                $transaction->invitation_id => [
                    'purchased_price' => $transaction->amount,
                    'status_active' => true,
                    'activated_at' => now(),
                ],
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            Notification::make()
                ->title('Gagal mengkonfirmasi transaksi!')
                ->body('Terjadi kesalahan: ' . $e->getMessage())
                ->danger()
                ->send();

            throw $e;
        }

        Notification::make()
            ->title('Transaksi berhasil dikonfirmasi!')
            ->body('Add-on "' . $transaction->addon->name . '" sudah aktif untuk undangan ' . $transaction->invitation->title . '.')
            ->success()
            ->send();
    }
}
