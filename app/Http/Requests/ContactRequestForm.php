<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequestForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => 'required|string|max:100',
            'lastName'  => 'required|string|max:100',
            'email'     => 'required|email|max:150',
            'company'   => 'nullable|string|max:150',
            'message'   => 'required|string|min:10',
        ];
    }

    public function messages()
    {
        return [
            'firstName.required' => 'Le prénom est obligatoire.',
            'lastName.required'  => 'Le nom est obligatoire.',
            'email.required'     => "L'email est obligatoire.",
            'message.required'   => "Veuillez décrire votre besoin juridique.",
        ];
    }
}
