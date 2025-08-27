<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    /**
     * Pas de restriction particulière, tout utilisateur peut mettre à jour un client.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation pour la mise à jour d'un client.
     */
    public function rules(): array
    {
        $clientId = $this->route('client')->id ?? null;

        return [
            'nom'   => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $clientId,
            'siret' => 'nullable|digits:14|unique:clients,siret,' . $clientId,
        ];
    }

    /**
     * Messages d’erreurs personnalisés.
     */
    public function messages(): array
    {
        return [
            'nom.required'   => 'Le nom est obligatoire.',
            'email.required' => 'L’email est obligatoire.',
            'email.email'    => 'L’email n’est pas valide.',
            'email.unique'   => 'Cet email est déjà associé à un autre client.',
            'siret.digits'   => 'Le SIRET doit contenir exactement 14 chiffres.',
            'siret.unique'   => 'Ce SIRET existe déjà pour un autre client.',
        ];
    }
}
