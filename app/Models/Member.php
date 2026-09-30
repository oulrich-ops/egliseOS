<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'member_number',
        'first_name',
        'last_name',
        'full_name',
        'gender',
        'birth_date',
        'birth_place',
        'photo_path',
        'phone',
        'secondary_phone',
        'email',
        'address',
        'city',
        'profession',
        'marital_status',
        'arrival_date',
        'joined_at',
        'baptized',
        'baptism_date',
        'baptism_place',
        'status',
        'previous_church',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'arrival_date' => 'date',
        'joined_at' => 'date',
        'baptism_date' => 'date',
        'baptized' => 'boolean',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_members')
            ->withPivot('joined_at', 'left_at', 'status', 'notes')
            ->withTimestamps();
    }

    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'group_position_members')
            ->withPivot('started_at', 'ended_at')
            ->withTimestamps();
    }

    public function memberCards(): HasMany
    {
        return $this->hasMany(MemberCard::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(MemberDocument::class);
    }
}
