<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\AddonPaymentController;
use App\Http\Controllers\Dashboard\AddonController;
use App\Http\Controllers\Dashboard\CheckoutController;
use App\Http\Controllers\Dashboard\GalleryController;
use App\Http\Controllers\Dashboard\GuestbookController;
use App\Http\Controllers\Dashboard\GuestCategoryController;
use App\Http\Controllers\Dashboard\GuestController;
use App\Http\Controllers\Dashboard\InvitationController;
use App\Http\Controllers\Dashboard\WhatsAppBlastController;
use App\Http\Controllers\Dashboard\WhatsAppDiagnosticController;
use App\Http\Controllers\Dashboard\WhatsAppPaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvitationRenderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QRGatewayController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ThemePreviewController;
use App\Http\Controllers\WelcomeScreenController;
use App\Http\Controllers\WishController;
use App\Models\Package;
use Illuminate\Support\Facades\Route;

// Landing Page & Public Preview
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/semua-tema', [ThemeController::class, 'index'])->name('themes.index');
Route::get('/preview/{themeSlug}', [ThemePreviewController::class, 'show'])->name('theme.preview');

// Public Pages
Route::get('/undangan-web', function () {
    $packages = Package::with('features')
        ->where('is_visible', true)
        ->orderBy('sort_order')
        ->get();

    return view('undangan-web', compact('packages'));
})->name('undangan-web');
Route::view('/buku-tamu', 'buku-tamu')->name('buku-tamu');
Route::view('/live-streaming', 'live-streaming')->name('live-streaming');
Route::view('/syarat-ketentuan', 'syarat-ketentuan')->name('syarat-ketentuan');
Route::view('/kebijakan-privasi', 'kebijakan-privasi')->name('kebijakan-privasi');
Route::view('/tentang-kami', 'tentang-kami')->name('tentang-kami');
Route::get('/hubungi-kami', [App\Http\Controllers\ContactController::class, 'show'])->name('hubungi-kami');
Route::post('/hubungi-kami', [App\Http\Controllers\ContactController::class, 'submit'])->name('hubungi-kami.submit');

// Admin Impersonation Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/impersonate', [\App\Http\Controllers\Admin\ImpersonationController::class, 'index'])->name('impersonate.index');
    Route::post('/impersonate/leave', [\App\Http\Controllers\Admin\ImpersonationController::class, 'leave'])->name('impersonate.leave');
    Route::post('/impersonate/{user}', [\App\Http\Controllers\Admin\ImpersonationController::class, 'switch'])->name('impersonate.switch');
});

// Google OAuth
Route::prefix('auth/google')->name('google.')->group(function () {
    Route::get('/', [SocialiteController::class, 'redirectToGoogle'])->name('redirect');
    Route::get('/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('callback');
});

// Dashboard Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        // Checkout & Packages
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

        // WhatsApp Manual Payment
        Route::get('/payment/{order}', [WhatsAppPaymentController::class, 'showInvoice'])->name('payment.invoice');
        Route::post('/payment/{order}/send-whatsapp', [WhatsAppPaymentController::class, 'sendWhatsApp'])->name('payment.send-whatsapp');

        // Invitations and nested resources
        Route::get('/invitations/check-slug', [InvitationController::class, 'checkSlug'])->name('invitations.check-slug');
        Route::resource('invitations', InvitationController::class);
        Route::resource('invitations.guests', GuestController::class)->except(['show']);
        Route::resource('invitations.guest-categories', GuestCategoryController::class)->except(['show', 'create', 'edit']);

        // Extended & Premium Actions
        Route::get('/invitations/{invitation}/guests/template', [GuestController::class, 'downloadTemplate'])->name('invitations.guests.template');
        Route::post('/invitations/{invitation}/guests/import', [GuestController::class, 'import'])->name('invitations.guests.import');
        Route::post('/invitations/{invitation}/guests/delete-selected', [GuestController::class, 'destroySelected'])->name('invitations.guests.destroy-selected');
        Route::delete('/invitations/{invitation}/guests', [GuestController::class, 'destroyAll'])->name('invitations.guests.destroy-all');
        Route::post('/invitations/{invitation}/gallery', [GalleryController::class, 'update'])->name('invitations.gallery.update');
        Route::delete('/invitations/{invitation}/gallery', [GalleryController::class, 'destroy'])->name('invitations.gallery.destroy');
        Route::post('/invitations/{invitation}/gift', [GiftController::class, 'update'])->name('invitations.gift.update');

        // Addon Management
        Route::get('/invitations/{invitation}/addons', [AddonController::class, 'index'])->name('invitations.addons.index');
        Route::post('/invitations/{invitation}/addons/{addon}/purchase', [AddonController::class, 'purchase'])->name('invitations.addons.purchase');
        Route::get('/invitations/{invitation}/addons/transactions/{transaction}/invoice', [AddonController::class, 'invoice'])->name('invitations.addons.invoice');
        Route::post('/invitations/{invitation}/addons/transactions/{transaction}/send-whatsapp', [AddonController::class, 'sendWhatsApp'])->name('invitations.addons.send-whatsapp');
        Route::post('/invitations/{invitation}/addons/{addon}/activate', [AddonController::class, 'activate'])->name('invitations.addons.activate');
        Route::post('/invitations/{invitation}/addons/{addon}/deactivate', [AddonController::class, 'deactivate'])->name('invitations.addons.deactivate');

        // WhatsApp Diagnostic
        Route::get('/whatsapp-diagnostic', [WhatsAppDiagnosticController::class, 'check'])->name('whatsapp.diagnostic');

        // WhatsApp Blast
        Route::post('/invitations/{invitation}/whatsapp/send', [WhatsAppBlastController::class, 'send'])->name('invitations.whatsapp.send');
        Route::post('/invitations/{invitation}/whatsapp/send/{guest}', [WhatsAppBlastController::class, 'sendSingle'])->name('invitations.whatsapp.send-single');
        Route::get('/invitations/{invitation}/whatsapp/logs', [WhatsAppBlastController::class, 'logs'])->name('invitations.whatsapp.logs');
        Route::post('/invitations/{invitation}/whatsapp/template', [WhatsAppBlastController::class, 'template'])->name('invitations.whatsapp.template');

        // QR RSVP Report (Real-Time)
        Route::get('/invitations/{invitation}/rsvp-report', [InvitationController::class, 'rsvpReport'])->name('invitations.rsvp-report');

        // QR RSVP Universal
        Route::get('/invitations/{invitation}/qr-rsvp', [InvitationController::class, 'qrRsvp'])->name('invitations.qr-rsvp');

        // Wishes
        Route::delete('/invitations/{invitation}/wishes/{wish}', [WishController::class, 'destroy'])->name('invitations.wishes.destroy');

        // Guestbook / QR Scanner
        Route::get('/invitations/{invitation}/guestbook', [GuestbookController::class, 'index'])->name('invitations.guestbook');
        Route::get('/invitations/{invitation}/guestbook/pengaturan-layar-sapa', [WelcomeScreenController::class, 'settings'])->name('invitations.guestbook.settings');
        Route::post('/invitations/{invitation}/guestbook/checkin', [GuestbookController::class, 'checkin'])->name('invitations.guestbook.checkin');
        Route::get('/invitations/{invitation}/guestbook/{guest}/ticket', [GuestbookController::class, 'ticket'])->name('invitations.guestbook.ticket');

        // Welcome Screen (Layar Sapa)
        Route::get('/invitations/{invitation}/welcome-screen', [WelcomeScreenController::class, 'index'])->name('welcome-screen.index');
        Route::get('/invitations/{invitation}/latest-checkin', [WelcomeScreenController::class, 'getLatestCheckIn'])->name('welcome-screen.latest-checkin');
        Route::post('/invitations/{invitation}/welcome-screen/settings', [WelcomeScreenController::class, 'updateSettings'])->name('welcome-screen.settings.update');
        Route::delete('/invitations/{invitation}/welcome-screen/gallery/{screenGallery}', [WelcomeScreenController::class, 'deleteGalleryImage'])->name('welcome-screen.gallery.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Payment Callbacks
Route::post('/payments/notification', [PaymentController::class, 'notification'])->name('payments.notification');
Route::get('/payments/finish', [PaymentController::class, 'finish'])->name('payments.finish');

// Addon Payment Callbacks
Route::get('/addon-payment/finish', [AddonPaymentController::class, 'finish'])->name('addon-payment.finish');

require __DIR__.'/auth.php';

// Public Invitation Page & Actions (Must be at the bottom to catch /slug)
Route::post('/invitations/{invitation}/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');
Route::post('/invitations/{invitation}/wish', [WishController::class, 'store'])->name('wish.store');

// QR Gateway RSVP Universal
Route::get('/{slug}/rsvp', [QRGatewayController::class, 'show'])->name('qr-gateway');
Route::get('/{slug}', [InvitationRenderController::class, 'show'])->name('invitation.show');
