<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Party extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'acronym',
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucwords($value),
            set: fn($value) => strtolower($value)
        );
    }

    protected function acronym(): Attribute
    {
        return Attribute::make(
            get: fn($value) => strtoupper($value),
            set: fn($value) => strtolower($value)
        );
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
