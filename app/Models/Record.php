<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'station_id',
        'image'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
