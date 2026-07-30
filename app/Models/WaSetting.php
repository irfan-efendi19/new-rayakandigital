<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaSetting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wa_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'invitation_id',
        'phone_number',
        'fonnte_token',
        'status',
        'admin_notes',
        'verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the WhatsApp setting.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the invitation associated with the WhatsApp setting.
     */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    /**
     * Device is fully connected and ready to send messages.
     */
    public function isConnected(): bool
    {
        return $this->status === 'CONNECTED' && ! empty($this->fonnte_token);
    }

    /**
     * Admin has verified the token and user can now scan QR.
     */
    public function isReadyToPair(): bool
    {
        return $this->status === 'READY_TO_PAIR' && ! empty($this->fonnte_token);
    }

    /**
     * Awaiting admin to inject the Fonnte token.
     */
    public function isPendingVerification(): bool
    {
        return $this->status === 'PENDING_VERIFICATION';
    }

    /**
     * Admin has rejected this number.
     */
    public function isRejected(): bool
    {
        return $this->status === 'REJECTED';
    }

    /**
     * User can trigger QR code scan (admin has set token).
     */
    public function canPair(): bool
    {
        return in_array($this->status, ['READY_TO_PAIR', 'PAIRING']) && ! empty($this->fonnte_token);
    }
}
