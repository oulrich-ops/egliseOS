<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'logo',
        'status',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role', 'status')
            ->withTimestamps();
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    public function memberCards(): HasMany
    {
        return $this->hasMany(MemberCard::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }
}
