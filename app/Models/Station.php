<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Station extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'enclosure_id',
        'name',
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucwords($value),
            set: fn($value) => strtolower($value)
        );
    }

    public function enclosure(): BelongsTo
    {
        return $this->belongsTo(Enclosure::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(Record::class);
    }
}
