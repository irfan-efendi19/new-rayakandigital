<?php

namespace App\Http\Controllers;

use App\Models\AddonTransaction;
use App\Models\Invitation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;

class InvoiceController extends Controller
{
    public function downloadPdf(Invitation $invitation)
    {
        Gate::authorize('view', $invitation);

        $invitation->load(['user', 'pricingTier', 'addons' => function ($query) {
            $query->wherePivot('status_active', true);
        }]);

        $latestOrder = $invitation->orders()
            ->where('payment_status', 'success')
            ->latest()
            ->first();

        $latestTransaction = AddonTransaction::where('invitation_id', $invitation->id)
            ->where('payment_status', 'settlement')
            ->latest()
            ->first();

        $invoiceNumber = $latestOrder?->invoice_id
            ?? $latestTransaction?->reference_order_id
            ?? 'RD-'.$invitation->created_at->format('Ymd').'-'.str_pad((string) $invitation->id, 4, '0', STR_PAD_LEFT);

        $packagePrice = $invitation->package_price;
        $packageName = ucfirst($invitation->currentTier());
        $addonTotal = $invitation->addons->sum('pivot.purchased_price');
        $grandTotal = $packagePrice + $addonTotal;

        $data = [
            'invoice_number' => $invoiceNumber,
            'issue_date' => now()->translatedFormat('d F Y'),
            'invitation' => $invitation,
            'user' => $invitation->user,
            'package_name' => $packageName,
            'package_price' => $packagePrice,
            'addons' => $invitation->addons,
            'addon_total' => $addonTotal,
            'grand_total' => $grandTotal,
        ];

        $pdf = Pdf::loadView('dashboard.billing.invoice_pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false);

        return $pdf->download('Invoice-'.$invoiceNumber.'-'.$invitation->slug.'.pdf');
    }
}
