<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFactureRequest extends FormRequest
{
    /**
     * Tout le monde peut créer une facture (pas de restriction ici).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation pour la création d'une facture.
     */
    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'date_emission' => 'required|date|date_format:Y-m-d',
            'date_echeance' => 'required|date|after_or_equal:date_emission|date_format:Y-m-d',
            'articles' => 'required|array|min:1',
            'articles.*.description' => 'required|string|max:255',
            'articles.*.quantite' => 'required|integer|min:1',
            'articles.*.prix_unitaire' => 'required|numeric|min:0',
            'articles.*.taux_tva' => 'required|in:0,5.5,10,20',
        ];
    }

    /**
     * Messages d’erreur personnalisés (style plus naturel).
     */
    public function messages(): array
    {
        return [
            'client_id.required' => 'Merci de choisir un client.',
            'client_id.exists' => 'Ce client n’existe pas dans la base.',
            'date_emission.required' => 'La date d’émission est obligatoire.',
            'date_emission.date' => 'La date d’émission doit être une date valide.',
            'date_echeance.required' => 'La date d’échéance est obligatoire.',
            'date_echeance.date' => 'La date d’échéance doit être une date valide.',
            'date_echeance.after_or_equal' => 'La date d’échéance ne peut pas être avant la date d’émission.',
            'articles.required' => 'Une facture doit contenir au moins un article.',
            'articles.*.description.required' => 'Chaque article doit avoir une description.',
            'articles.*.quantite.min' => 'Impossible d’avoir une quantité à zéro.',
            'articles.*.prix_unitaire.min' => 'Le prix unitaire doit être positif.',
            'articles.*.taux_tva.in' => 'Le taux de TVA doit être 0%, 5.5%, 10% ou 20%.',
        ];
    }
}
