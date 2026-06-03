<?php

namespace App\Services;

use App\Models\Invitation;
use App\Models\Package;
use App\Models\PlatformFeature;
use Illuminate\Support\Collection;

class FeatureGateService
{
    public function canAccess(Invitation $invitation, string $featureKey): bool
    {
        return $invitation->hasFeature($featureKey) || $invitation->hasAddon($featureKey);
    }

    public function isLocked(Invitation $invitation, string $featureKey): bool
    {
        return !$this->canAccess($invitation, $featureKey);
    }

    public function lockedState(Invitation $invitation, string $featureKey): array
    {
        $hasAccess = $this->canAccess($invitation, $featureKey);

        if ($hasAccess) {
            return [
                'locked' => false,
                'message' => null,
                'required_tier' => null,
            ];
        }

        $requiredTier = $this->requiredTierForFeature($featureKey);

        return [
            'locked' => true,
            'message' => $requiredTier
                ? 'Fitur ini memerlukan paket ' . $requiredTier->package_name . '. Silakan upgrade paket Anda.'
                : 'Fitur ini tidak tersedia pada paket Anda.',
            'required_tier' => $requiredTier?->package_name ?? null,
            'required_tier_code' => $requiredTier?->package_code ?? null,
        ];
    }

    public function requiredTierForFeature(string $featureKey): ?Package
    {
        $feature = PlatformFeature::where('feature_key', $featureKey)->first();

        if (!$feature) {
            return null;
        }

        $package = $feature->packages()
            ->orderBy('price')
            ->first();

        return $package;
    }

    public function featuresByGroup(): Collection
    {
        return PlatformFeature::query()
            ->orderBy('group_name')
            ->orderBy('feature_name')
            ->get()
            ->groupBy('group_name');
    }

    public function allFeatureKeys(): array
    {
        return PlatformFeature::pluck('feature_key')->toArray();
    }
}
