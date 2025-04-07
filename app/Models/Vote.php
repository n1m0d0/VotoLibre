<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'record_id',
        'party_id',
        'amount',
    ];

    public function record(): BelongsTo
    {
        return $this->belongsTo(Record::class);
    }

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }
}
