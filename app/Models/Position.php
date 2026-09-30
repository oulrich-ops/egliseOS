<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Position extends Model
{
    protected $fillable = [
        'tenant_id',
        'group_id',
        'name',
        'description',
        'sort_order',
        'status',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'group_position_members')
            ->withPivot('started_at', 'ended_at')
            ->withTimestamps();
    }
}
