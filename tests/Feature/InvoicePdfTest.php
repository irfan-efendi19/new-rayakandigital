<?php

use App\Models\Invitation;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdfDocument;
use Carbon\CarbonImmutable;

test('invitation owner can download a valid invoice pdf', function () {
    $user = User::factory()->create();
    $invitation = Invitation::factory()->for($user)->create([
        'slug' => 'andi-dan-sari',
        'title' => 'Pernikahan Andi & Sari',
        'bride_name' => 'Sari',
        'groom_name' => 'Andi',
        'created_at' => '2026-08-27 09:00:00',
    ]);

    $response = $this->actingAs($user)
        ->get(route('dashboard.invitations.invoice-pdf', $invitation));

    $response->assertSuccessful()
        ->assertHeader('content-type', 'application/pdf');

    expect($response->headers->get('content-disposition'))
        ->toContain('Invoice-RD-20260827-'.str_pad((string) $invitation->id, 4, '0', STR_PAD_LEFT))
        ->and(substr($response->getContent(), 0, 4))->toBe('%PDF');
});

test('user cannot download another users invoice', function () {
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();
    $invitation = Invitation::factory()->for($owner)->create();

    $this->actingAs($otherUser)
        ->get(route('dashboard.invitations.invoice-pdf', $invitation))
        ->assertForbidden();
});

test('invoice print time follows the invitation timezone', function () {
    $this->travelTo(CarbonImmutable::parse('2026-08-27 00:30:00', 'UTC'));

    $user = User::factory()->create();
    $invitation = Invitation::factory()->for($user)->create([
        'timezone' => 'Asia/Jayapura',
    ]);

    $document = Mockery::mock(DomPdfDocument::class);

    Pdf::shouldReceive('loadView')
        ->once()
        ->withArgs(function (string $view, array $data): bool {
            expect($view)->toBe('dashboard.billing.invoice_pdf')
                ->and($data['issue_date'])->toBe('27 Agustus 2026, 09:30 WIT');

            return true;
        })
        ->andReturn($document);

    $document->shouldReceive('setPaper')->once()->with('a4', 'portrait')->andReturnSelf();
    $document->shouldReceive('setWarnings')->once()->with(false)->andReturnSelf();
    $document->shouldReceive('download')->once()->andReturn(response('%PDF')->header('content-type', 'application/pdf'));

    $this->actingAs($user)
        ->get(route('dashboard.invitations.invoice-pdf', $invitation))
        ->assertSuccessful();
});

test('invalid invitation timezone falls back to WIB', function () {
    $invitation = Invitation::factory()->make(['timezone' => 'Invalid/Timezone']);

    expect($invitation->effectiveTimezone())->toBe(Invitation::DEFAULT_TIMEZONE)
        ->and($invitation->timezoneAbbreviation())->toBe('WIB');
});
