<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviewData extends Model
{
    use HasFactory;

    protected $fillable = [
        'bride_name',
        'groom_name',
        'bride_nickname',
        'groom_nickname',
        'bride_parents',
        'groom_parents',
        'title',
        'event_date_offset_days',
        'event_time',
        'event_time_end',
        'venue_name',
        'venue_address',
        'venue_maps_url',
        'love_story',
        'gallery_photos',
        'gift_bank_name',
        'gift_bank_account',
        'gift_bank_holder',
        'gift_banks',
        'events',
    ];

    protected function casts(): array
    {
        return [
            'event_date_offset_days' => 'integer',
            'gallery_photos' => 'array',
            'gift_banks' => 'array',
            'events' => 'array',
        ];
    }

    public function getEventDateAttribute(): string
    {
        return now()->addDays($this->event_date_offset_days)->format('Y-m-d');
    }

    public function getParsedEventsAttribute(): array
    {
        $events = $this->events ?? [];
        $baseDate = now()->addDays($this->event_date_offset_days);

        return array_map(function ($event, $index) use ($baseDate) {
            $offset = $event['date_offset_days'] ?? 0;
            return [
                'event_title' => $event['event_title'] ?? 'Acara',
                'event_date' => $baseDate->copy()->addDays($offset)->format('Y-m-d'),
                'start_time' => $event['start_time'] ?? '08:00',
                'end_time' => $event['end_time'] ?? null,
                'is_until_finished' => $event['is_until_finished'] ?? false,
                'place_name' => $event['place_name'] ?? '',
                'place_address' => $event['place_address'] ?? '',
                'google_maps_url' => $event['google_maps_url'] ?? null,
                'sort_order' => $index,
            ];
        }, $events, array_keys($events));
    }

    public static function getPreview(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            static::defaultData()
        );
    }

    public static function defaultData(): array
    {
        return [
            'bride_name' => 'Ani Suryani',
            'groom_name' => 'Budi Santoso',
            'bride_nickname' => 'Ani',
            'groom_nickname' => 'Budi',
            'bride_parents' => 'Bapak Surya & Ibu Dewi',
            'groom_parents' => 'Bapak Santo & Ibu Ratna',
            'title' => 'Pernikahan Budi & Ani',
            'event_date_offset_days' => 60,
            'event_time' => '10:00',
            'event_time_end' => '14:00',
            'venue_name' => 'Grand Ballroom Hotel Mulia',
            'venue_address' => 'Jl. Asia Afrika No.8, Senayan, Jakarta Selatan 10270',
            'venue_maps_url' => 'https://maps.google.com/?q=-6.2088,106.8456',
            'love_story' => 'Kami bertemu di bangku kuliah pada tahun 2020. Sebuah perkenalan sederhana yang tumbuh menjadi cinta yang indah.',
            'gallery_photos' => [
                'https://picsum.photos/seed/wedding1/400/400',
                'https://picsum.photos/seed/wedding2/400/400',
                'https://picsum.photos/seed/wedding3/400/400',
            ],
            'gift_bank_name' => 'Bank Central Asia (BCA)',
            'gift_bank_account' => '1234567890',
            'gift_bank_holder' => 'Ani Suryani',
            'gift_banks' => [
                [
                    'bank_name' => 'Bank Central Asia (BCA)',
                    'account_number' => '1234567890',
                    'account_holder' => 'Ani Suryani',
                ],
            ],
            'events' => [
                [
                    'event_title' => 'Akad Nikah',
                    'date_offset_days' => 0,
                    'start_time' => '08:00',
                    'end_time' => '10:00',
                    'is_until_finished' => false,
                    'place_name' => 'Masjid Agung Al-Hikmah',
                    'place_address' => 'Jl. Merdeka No. 10, Jakarta Pusat',
                    'google_maps_url' => 'https://maps.google.com/?q=-6.2088,106.8456',
                ],
                [
                    'event_title' => 'Resepsi',
                    'date_offset_days' => 0,
                    'start_time' => '11:00',
                    'end_time' => '16:00',
                    'is_until_finished' => false,
                    'place_name' => 'Grand Ballroom Hotel Mulia',
                    'place_address' => 'Jl. Asia Afrika No.8, Senayan, Jakarta Selatan 10270',
                    'google_maps_url' => 'https://maps.google.com/?q=-6.2088,106.8456',
                ],
            ],
        ];
    }
}
