<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LawyerResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->user->name ?? null,
            'email' => $this->user->email ?? null,
            'specialty' => $this->specialty,
            'firm_name' => $this->firm_name,
            'status' => $this->moderation_state === 'pending'
                ? 'en attente'
                : ($this->moderation_state === 'approved'
                    ? 'actif'
                    : 'bloqué'),
            'moderation_notes' => $this->moderation_notes,
            'moderation_state' => $this->moderation_state,
            'profile' => $this->profile,
            'office_address' => $this->office_address,
            'bar_id' => $this->bar_id,
            'vidio_url' => $this->vidio_url,
            'experience' => $this->experience,
            'review' => $this->review
        ];
    }
}
