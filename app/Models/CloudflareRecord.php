<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloudflareRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
        'proxy' => 'boolean',
    ];

    protected $appends = [
        'fqdn',
    ];

    public function fqdn(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->hostname === '@' ? $this->domain : $this->hostname.'.'.$this->domain,
        );
    }

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function team(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
}
