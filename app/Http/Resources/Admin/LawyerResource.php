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
            'id' => $this->id, // always useful for Vue/Inertia
            'name' => $this->user->name ?? null,
            'email' => $this->user->email ?? null,
            'specialty' => $this->specialty, // ✅ fixed typo
            'firm_name' => $this->firm_name,
            'status' => $this->is_published ? 'actif' : 'bloqué',
            'moderation_notes' => $this->moderation_notes,
            'moderation_state' => $this->moderation_state,
        ];
    }
}
