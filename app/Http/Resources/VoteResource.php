<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'record_id' => $this->record_id,
            'party_id' => $this->party_id,
            'amount' => $this->amount,
        ];
    }

    public function with($request)
    {
        return [
            'is_success' => true
        ];
    }
}
