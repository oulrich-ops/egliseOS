<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberCard extends Model
{
    protected $fillable = [
        'tenant_id',
        'member_id',
        'card_number',
        'verification_token',
        'pdf_path',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'date',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
