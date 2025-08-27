<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFactureRequest extends FormRequest
{
    /**
     * Autorisation : tout utilisateur authentifié peut modifier une facture.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation pour la mise à jour d'une facture.
     */
   public function rules(): array
{
    return [
        'client_id' => 'required|exists:clients,id',
        'date_emission' => 'required|date|date_format:Y-m-d',
        'date_echeance' => 'required|date|after_or_equal:date_emission|date_format:Y-m-d',
        'notes' => 'nullable|string|max:500',
        'articles' => 'sometimes|array|min:1',
        'articles.*.description' => 'required_with:articles|string|max:255',
        'articles.*.quantite' => 'required_with:articles|integer|min:1',
        'articles.*.prix_unitaire' => 'required_with:articles|numeric|min:0',
        'articles.*.taux_tva' => 'required_with:articles|in:0,5.5,10,20',
    ];
}

    /**
     * Messages d’erreurs personnalisés.
     */
    public function messages(): array
{
    return [
        'client_id.required' => 'Merci de sélectionner un client.',
        'client_id.exists' => 'Le client choisi n’existe pas.',
        'date_emission.required' => 'La date d’émission est obligatoire.',
        'date_emission.date' => 'La date d’émission doit être valide.',
        'date_echeance.required' => 'La date d’échéance est obligatoire.',
        'date_echeance.date' => 'La date d’échéance doit être valide.',
        'date_echeance.after_or_equal' => 'La date d’échéance ne peut pas être avant la date d’émission.',
        'articles.min' => 'Une facture doit contenir au moins un article.',
        'articles.*.description.required_with' => 'Chaque article doit avoir une description.',
        'articles.*.quantite.required_with' => 'Chaque article doit préciser une quantité.',
        'articles.*.prix_unitaire.required_with' => 'Le prix unitaire est obligatoire.',
        'articles.*.taux_tva.in' => 'Le taux de TVA doit être 0%, 5.5%, 10% ou 20%.',
    ];
}
}
