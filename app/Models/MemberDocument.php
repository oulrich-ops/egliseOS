<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberDocument extends Model
{
    protected $fillable = [
        'tenant_id',
        'member_id',
        'type',
        'title',
        'reference',
        'content',
        'metadata',
        'issued_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'issued_at' => 'date',
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
