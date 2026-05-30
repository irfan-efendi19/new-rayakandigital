<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Dashboard\GuestController;
use App\Http\Controllers\Dashboard\InvitationController;
use App\Http\Controllers\Dashboard\CheckoutController;
use App\Http\Controllers\Dashboard\GalleryController;
use App\Http\Controllers\Dashboard\GiftController;
use App\Http\Controllers\Dashboard\WhatsAppPaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvitationRenderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\ThemePreviewController;
use App\Http\Controllers\WishController;
use Illuminate\Support\Facades\Route;

// Landing Page & Public Preview
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/preview/{themeSlug}', [ThemePreviewController::class, 'show'])->name('theme.preview');

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
        Route::resource('invitations', InvitationController::class);
        Route::resource('invitations.guests', GuestController::class)->except(['show']);

        // Extended & Premium Actions
        Route::post('/invitations/{invitation}/guests/import', [GuestController::class, 'import'])->name('invitations.guests.import');
        Route::post('/invitations/{invitation}/gallery', [GalleryController::class, 'update'])->name('invitations.gallery.update');
        Route::delete('/invitations/{invitation}/gallery', [GalleryController::class, 'destroy'])->name('invitations.gallery.destroy');
        Route::post('/invitations/{invitation}/gift', [GiftController::class, 'update'])->name('invitations.gift.update');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Payment Callbacks
Route::post('/payments/notification', [PaymentController::class, 'notification'])->name('payments.notification');
Route::get('/payments/finish', [PaymentController::class, 'finish'])->name('payments.finish');

require __DIR__.'/auth.php';

// Public Invitation Page & Actions (Must be at the bottom to catch /slug)
Route::post('/invitations/{invitation}/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');
Route::post('/invitations/{invitation}/wish', [WishController::class, 'store'])->name('wish.store');
Route::get('/{slug}', [InvitationRenderController::class, 'show'])->name('invitation.show');
