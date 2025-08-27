<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Pas de restriction ici, tout utilisateur peut créer un client.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation pour la création d'un client.
     */
    public function rules()
    {
        return [
            'nom'   => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'siret' => 'nullable|digits:14|unique:clients,siret',
            'adresse'=> 'nullable|string|max:255',
            'ville'=> 'nullable|string|max:255',
            'telephone'=> 'nullable|string|max:255',
        ];
    }

    /**
     * Messages d'erreurs personnalisés (plus clairs et concis).
     */
    public function messages()
    {
        return [
            'nom.required'   => 'Le nom est obligatoire.',
            'email.required' => 'Un email est obligatoire.',
            'email.email'    => 'Format de l’email invalide.',
            'email.unique'   => 'Cet email est déjà enregistré.',
            'siret.digits'   => 'Le numéro SIRET doit contenir exactement 14 chiffres.',
            'siret.unique'   => 'Ce SIRET existe déjà dans la base.',
        ];
    }
}
