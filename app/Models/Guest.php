<?php

namespace App\Models;

use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Database\Factories\GuestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Guest extends Model
{
    /** @use HasFactory<GuestFactory> */
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'name',
        'slug',
        'phone',
        'address',
        'qr_code_token',
        'attendance_status',
        'checked_in_at',
    ];

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Guest $guest) {
            if (empty($guest->qr_code_token)) {
                $guest->qr_code_token = (string) Str::uuid();
            }

            if (empty($guest->slug)) {
                $guest->slug = static::resolveDuplicateSlug(
                    $guest->invitation_id,
                    Str::slug($guest->name)
                );
            }
        });

        static::updating(function (Guest $guest) {
            if ($guest->isDirty('name') && ! $guest->isDirty('slug')) {
                $guest->slug = static::resolveDuplicateSlug(
                    $guest->invitation_id,
                    Str::slug($guest->name),
                    $guest->id
                );
            }
        });
    }

    protected static function resolveDuplicateSlug(int $invitationId, string $slug, ?int $excludeId = null): string
    {
        $baseSlug = $slug;
        $counter = 1;

        while (true) {
            $query = static::where('invitation_id', $invitationId)
                ->where('slug', $slug);

            if ($excludeId !== null) {
                $query->where('id', '!=', $excludeId);
            }

            if (! $query->exists()) {
                return $slug;
            }

            $counter++;
            $slug = $baseSlug.'-'.$counter;
        }
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function whatsappLogs(): HasMany
    {
        return $this->hasMany(WhatsappLog::class);
    }

    public function getPersonalizedLinkAttribute(): string
    {
        return route('invitation.show', $this->invitation->slug).'?to='.urlencode($this->slug);
    }

    public function getWhatsappMessageAttribute(): string
    {
        return $this->invitation->parseWhatsappTemplate($this);
    }

    public function getWaStatusAttribute(): ?string
    {
        $latestLog = $this->relationLoaded('whatsappLogs')
            ? $this->whatsappLogs->first()
            : $this->whatsappLogs()->latest()->first();

        return $latestLog?->status;
    }

    /**
     * Tandai tamu sebagai hadir (check-in). Idempoten — return false jika sudah hadir.
     */
    public function markAsHadir(): bool
    {
        if ($this->isHadir()) {
            return false;
        }

        $this->update([
            'attendance_status' => 'hadir',
            'checked_in_at' => now(),
        ]);

        return true;
    }

    /**
     * Cek apakah tamu sudah check-in.
     */
    public function isHadir(): bool
    {
        return $this->attendance_status === 'hadir';
    }

    /**
     * Generate QR Code SVG dari qr_code_token menggunakan chillerlan/php-qrcode.
     */
    public function getQrCodeSvgAttribute(): string
    {
        if (empty($this->qr_code_token)) {
            return '';
        }

        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel' => QRCode::ECC_M,
            'addQuietzone' => true,
            'quietzoneSize' => 2,
            'drawLightModules' => false,
            'outputBase64' => false,
            'svgAddXmlHeader' => false,
            'moduleValues' => [
                QRMatrix::M_DARKMODULE => '#1e293b',
                QRMatrix::M_DATA_DARK => '#1e293b',
                QRMatrix::M_FINDER_DARK => '#1e293b',
                QRMatrix::M_SEPARATOR_DARK => '#1e293b',
                QRMatrix::M_ALIGNMENT_DARK => '#1e293b',
                QRMatrix::M_TIMING_DARK => '#1e293b',
                QRMatrix::M_FORMAT_DARK => '#1e293b',
                QRMatrix::M_VERSION_DARK => '#1e293b',
                QRMatrix::M_QUIETZONE_DARK => '#1e293b',
                QRMatrix::M_LOGO_DARK => '#1e293b',
                QRMatrix::M_FINDER_DOT => '#1e293b',
            ],
        ]);

        return (new QRCode($options))->render($this->qr_code_token);
    }
}
