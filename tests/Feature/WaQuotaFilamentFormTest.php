<?php

use App\Filament\Resources\SystemConfigs\Pages\EditSystemConfig;
use App\Models\Invitation;
use App\Models\SystemConfig;
use App\Models\User;
use Livewire\Livewire;

test('filament edit system config saves global wa blast quota limit', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $config = SystemConfig::create([
        'demo_duration_days' => 3,
        'demo_grace_period_days' => 30,
        'wa_blast_quota_limit' => null,
    ]);

    Livewire::actingAs($admin)
        ->test(EditSystemConfig::class, ['record' => $config->getRouteKey()])
        ->assertFormFieldExists('wa_blast_quota_limit')
        ->fillForm([
            'wa_blast_quota_limit' => 100,
        ])
        ->call('save');

    $this->assertDatabaseHas('system_configs', [
        'id' => $config->id,
        'wa_blast_quota_limit' => 100,
    ]);
});

test('invitation reads global wa blast quota limit', function () {
    SystemConfig::create(['wa_blast_quota_limit' => 50]);

    $invitation = Invitation::factory()->create(['wa_sent_count' => 10]);

    expect($invitation->waQuotaLimit())->toBe(50);
    expect($invitation->remainingWaQuota())->toBe(40);
    expect($invitation->isWaQuotaExhausted())->toBeFalse();
});
