<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AffiliateApplicationRequest;
use App\Http\Requests\AffiliateBankRequest;
use App\Http\Requests\AffiliateLinkRequest;
use App\Http\Requests\AffiliateLinkUpdateRequest;
use App\Http\Requests\AffiliatePayoutRequest;
use App\Models\AffiliateLink;
use App\Models\MarketingAsset;
use App\Services\AffiliatePayoutService;
use App\Services\AffiliateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AffiliateController extends Controller
{
    public function index(Request $request, AffiliateService $service): Response
    {
        abort_if($request->user()->is_banned, 403);
        $affiliate = $request->user()->affiliate()->with(['tier', 'promotion'])->first();
        $settings = $service->settings();
        $balance = $affiliate ? $service->balance($affiliate) : null;
        $links = $affiliate?->links()->latest('id')->paginate(10, ['*'], 'links_page');
        $payouts = $affiliate?->payouts()->latest('id')->paginate(10, ['*'], 'payouts_page');
        $commissions = $affiliate?->commissions()->with('order:id,order_id,package_type')
            ->latest('id')->paginate(10, ['*'], 'sales_page');
        $stats = $affiliate ? [
            'clicks' => $affiliate->links()->sum('clicks'),
            'sales' => $affiliate->commissions()->where('status', 'earned')->count(),
            'rate' => $service->rate($affiliate),
        ] : null;
        $assets = $affiliate?->status === 'approved'
            ? MarketingAsset::where('is_active', true)->latest('id')->get() : collect();

        return response()->view('dashboard.affiliate.index', compact(
            'affiliate', 'settings', 'balance', 'links', 'payouts', 'commissions', 'stats', 'assets',
        ))->header('Cache-Control', 'private, no-store');
    }

    public function store(AffiliateApplicationRequest $request, AffiliateService $service): RedirectResponse
    {
        $service->apply($request->user(), $request->validated());

        return back()->with('success', 'Pendaftaran mitra dikirim. Admin akan memverifikasi data Anda.');
    }

    public function bank(AffiliateBankRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $request->user()->affiliate()->lockForUpdate()->firstOrFail()->update($request->validated());
        });

        return back()->with('success', 'Rekening diperbarui. Pengajuan yang sudah dibuat tetap menggunakan rekening sebelumnya.');
    }

    public function link(AffiliateLinkRequest $request): RedirectResponse
    {
        $request->user()->affiliate()->firstOrFail()->links()->create($request->validated());

        return back()->with('success', 'Link referral berhasil dibuat.');
    }

    public function payout(AffiliatePayoutRequest $request, AffiliatePayoutService $service): RedirectResponse
    {
        $service->request($request->user()->affiliate()->firstOrFail(), (int) $request->validated('amount'));

        return back()->with('success', 'Pengajuan pencairan terkirim. Saldo telah dicadangkan sampai diproses admin.');
    }

    public function updateLink(AffiliateLinkUpdateRequest $request, AffiliateLink $link): RedirectResponse
    {
        abort_unless($request->user()->affiliate()->eligible()->where('id', $link->affiliate_id)->exists(), 403);

        $link->update($request->validated());

        return back()->with('success', 'Link referral berhasil diperbarui.');
    }

    public function destroyLink(Request $request, AffiliateLink $link): RedirectResponse
    {
        $affiliate = $request->user()->affiliate()->eligible()->where('id', $link->affiliate_id)->firstOrFail();

        abort_if($affiliate->links()->count() <= 1, 422, 'Minimal harus ada satu link referral.');

        $link->delete();

        return back()->with('success', 'Link referral berhasil dihapus.');
    }

    public function download(Request $request, MarketingAsset $asset): StreamedResponse
    {
        abort_unless(! $request->user()->is_banned && $request->user()->affiliate()->eligible()->exists(), 403);
        abort_unless($asset->is_active && str_starts_with($asset->file_path, 'marketing-kit/')
            && ! str_contains($asset->file_path, '..') && Storage::disk('local')->exists($asset->file_path), 404);

        return Storage::disk('local')->download($asset->file_path);
    }
}
