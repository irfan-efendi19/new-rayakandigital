<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\AddonTransaction;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function downloadPdf($id)
    {
        $invitation = Invitation::with(['user', 'addons' => function ($query) {
            $query->wherePivot('status_active', true);
        }])->findOrFail($id);

        $latestTransaction = AddonTransaction::where('invitation_id', $invitation->id)
            ->where('payment_status', 'settlement')
            ->latest()
            ->first();

        $invoiceNumber = $latestTransaction
            ? $latestTransaction->reference_order_id
            : 'INV-BASIC-' . $invitation->id . '-' . date('Ymd');

        $packagePrice = $invitation->package_price;
        $addonTotal = $invitation->addons->sum('pivot.purchased_price');
        $grandTotal = $packagePrice + $addonTotal;

        $data = [
            'invoice_number' => $invoiceNumber,
            'issue_date'     => now()->translatedFormat('d F Y'),
            'invitation'     => $invitation,
            'user'           => $invitation->user,
            'package_price'  => $packagePrice,
            'addons'         => $invitation->addons,
            'grand_total'    => $grandTotal,
        ];

        $pdf = Pdf::loadView('dashboard.billing.invoice_pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false);

        return $pdf->download('Invoice-' . $invoiceNumber . '-' . $invitation->slug . '.pdf');
    }
}
