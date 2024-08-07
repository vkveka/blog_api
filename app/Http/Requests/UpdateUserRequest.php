<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'pseudo' => 'nullable|string|max:255',
            'image' => 'nullable|mimes:jpg,jpeg,png,svg|max:2048',
            'email' => [
                Rule::unique('users', 'email')->ignore($this->user),
                'email'
            ],
            'oldPassword' => 'nullable',
            'password' => [
                'confirmed',
                'nullable',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ]
        ];
    }

    public function messages()
    {
        return [
            'pseudo.required' => 'Le champ "nom" est requis.',
            'pseudo.string' => 'Le champ "nom" doit être une chaîne de caractères.',
            'pseudo.max' => 'Le champ nom ne doit pas dépasser 10 caratères.',
            'email.required' => 'Le champ "email" est requis.',
            'email.email' => 'Entrez une adresse mail valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.required' => 'Le champ mot de passe est requis.',
            'password.string' => 'Le champ mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au minimum 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne sont pas identiques.',
        ];
    }
}
