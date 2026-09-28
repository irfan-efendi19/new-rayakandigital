<?php

namespace App\Services;

use App\Models\Invitation;
use Illuminate\Support\Carbon;

class WelcomeScreenData
{
    public function configuration(Invitation $invitation): array
    {
        $screen = $invitation->screen;
        $background = $invitation->screen_background_video ?: $invitation->screen_background_image;

        return [
            'title' => $screen?->custom_title ?: 'Selamat Datang di Pernikahan',
            'names' => $invitation->screen_bride_names ?: $invitation->couple_nickname,
            'theme' => $screen?->selected_theme ?? 'minimal-clean',
            'background' => [
                'type' => $invitation->screen_background_video ? 'video' : 'image',
                'url' => $background ? asset('storage/'.$background) : null,
            ],
            'galleries' => $invitation->screenGalleries()->orderBy('sort_order')->orderBy('id')
                ->get(['id', 'image_path'])->map(fn ($image) => [
                    'id' => $image->id,
                    'url' => asset('storage/'.$image->image_path),
                ])->values()->all(),
            'show_wishes_wall' => $screen?->show_wishes_wall ?? true,
            'wishes' => $this->wishes($invitation),
        ];
    }

    public function wishes(Invitation $invitation): array
    {
        if ($invitation->screen?->show_wishes_wall === false) {
            return [];
        }

        return $invitation->wishes()->where('is_hidden', false)->latest('id')->limit(50)
            ->get(['id', 'guest_name', 'message', 'created_at'])->map(fn ($wish) => [
                'id' => $wish->id,
                'name' => $wish->guest_name,
                'message' => $wish->message,
                'created_at' => $wish->created_at->toIso8601String(),
            ])->all();
    }

    public function checkins(Invitation $invitation, array $filters): array
    {
        $query = $invitation->guests()->where('attendance_status', 'hadir')->whereNotNull('checked_in_at');
        $since = isset($filters['since']) ? Carbon::parse($filters['since'])->setTimezone(config('app.timezone')) : null;

        if ($since) {
            $query->where(function ($query) use ($since, $filters) {
                $query->where('checked_in_at', '>', $since)
                    ->orWhere(function ($query) use ($since, $filters) {
                        $query->where('checked_in_at', $since)->where('id', '>', $filters['after_id'] ?? 0);
                    });
            })->orderBy('checked_in_at')->orderBy('id');
        } else {
            $query->orderByDesc('checked_in_at')->orderByDesc('id');
        }

        $guests = $query->limit(101)->get(['id', 'name', 'checked_in_at']);
        $hasMore = $guests->count() > 100;
        $guests = $guests->take(100)->sortBy([['checked_in_at', 'asc'], ['id', 'asc']])->values();
        $order = $invitation->guests()->where('attendance_status', 'hadir')->whereNotNull('checked_in_at')
            ->orderBy('checked_in_at')->orderBy('id')->pluck('id')->flip();
        $last = $guests->last();

        return [
            'success' => true,
            'guests' => $guests->map(fn ($guest) => [
                'id' => $guest->id,
                'name' => $guest->name,
                'checked_in_at' => $guest->checked_in_at->toIso8601String(),
                'checkin_order' => $order->get($guest->id, 0) + 1,
            ])->all(),
            'has_more' => $since !== null && $hasMore,
            'next_cursor' => $last ? [
                'since' => $last->checked_in_at->toIso8601String(),
                'after_id' => $last->id,
            ] : null,
            'server_time' => now()->toIso8601String(),
        ];
    }
}
