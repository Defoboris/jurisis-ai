<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LawyerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'   => 'required|exists:users,id',
            'profile'   => 'nullable|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'bar_id'    => 'nullable|string|max:255',
            'firm_name' => 'nullable|string|max:255',
            'office_address' => 'nullable|string|max:255',
            'headline'  => 'nullable|string|max:255',
            'bio'       => 'nullable|string',
            'vidio_url' => 'nullable|string',
            'moderation_state' => 'in:pending,approved,rejected',
            'moderation_notes' => 'nullable|string',
            'reiew' => 'nullable|numeric',
            'experience' => 'nullable|numeric',
        ];
    }
}
