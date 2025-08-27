<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use App\Models\Client;
use App\Http\Requests\StoreFactureRequest;
use App\Http\Requests\UpdateFactureRequest;
use Illuminate\Http\JsonResponse;

class FactureController extends Controller
{
    /**
     * Afficher la liste paginée des factures avec clients et articles.
     */
    public function index(): JsonResponse
    {
        $factures = Facture::with(['client', 'articles'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $factures
        ]);
    }

    /**
     * Créer une nouvelle facture avec ses articles.
     */
    public function store(StoreFactureRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Créer l'instance de la facture
        $facture = new Facture([
            'client_id' => $validated['client_id'],
            'date_emission' => $validated['date_emission'],
            'date_echeance' => $validated['date_echeance'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Générer un numéro unique
        $facture->numero_facture = $facture->genererNumeroFacture();
        $facture->save();

        // Ajouter les articles
        if (!empty($validated['articles'])) {
            foreach ($validated['articles'] as $article) {
                $facture->articles()->create([
                    'description' => $article['description'],
                    'quantite' => $article['quantite'],
                    'prix_unitaire' => $article['prix_unitaire'],
                    'taux_tva' => $article['taux_tva'],
                ]);
            }
        }

        // Calculer et mettre à jour les totaux
        $facture->calculerTotaux();

        return response()->json([
            'success' => true,
            'message' => 'Facture créée avec succès.',
            'data' => $facture->load('client', 'articles')
        ], 201);
    }

    /**
     * Afficher une facture spécifique avec ses articles et client.
     */
    public function show(Facture $facture): JsonResponse
    {
        $facture->load('client', 'articles');

        return response()->json([
            'success' => true,
            'data' => $facture
        ]);
    }

    /**
     * Mettre à jour une facture et ses articles.
     */
    public function update(UpdateFactureRequest $request, Facture $facture): JsonResponse
    {
        $validated = $request->validated();

        // Mettre à jour les informations de la facture
        $facture->update([
            'client_id' => $validated['client_id'],
            'date_emission' => $validated['date_emission'],
            'date_echeance' => $validated['date_echeance'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Mettre à jour les articles si fournis
        if (!empty($validated['articles'])) {
            $facture->articles()->delete(); // Supprime les anciennes lignes
            foreach ($validated['articles'] as $article) {
                $facture->articles()->create([
                    'description' => $article['description'],
                    'quantite' => $article['quantite'],
                    'prix_unitaire' => $article['prix_unitaire'],
                    'taux_tva' => $article['taux_tva'],
                ]);
            }
        }

        // Recalculer les totaux
        $facture->calculerTotaux();

        return response()->json([
            'success' => true,
            'message' => 'Facture mise à jour avec succès.',
            'data' => $facture->load('client', 'articles')
        ]);
    }

    /**
     * Supprimer une facture avec ses articles.
     */
    public function destroy(Facture $facture): JsonResponse
    {
        $facture->delete();

        return response()->json([
            'success' => true,
            'message' => 'Facture supprimée avec succès.'
        ]);
    }

    /**
     * Exporter toutes les factures au format JSON.
     */
    public function exportJson(): JsonResponse
    {
        $factures = Facture::with(['client', 'articles'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $factures,
            'exported_at' => now()->toISOString()
        ]);
    }

    /**
     * Exporter toutes les données : clients et factures.
     */
    public function exportComplet(): JsonResponse
    {
        $clients = Client::with(['factures.articles'])
            ->orderBy('created_at', 'desc')
            ->get();

        $factures = Facture::with(['client', 'articles'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'clients' => $clients,
                'factures' => $factures,
            ],
            'exported_at' => now()->toISOString(),
            'total_clients' => $clients->count(),
            'total_factures' => $factures->count(),
            'total_montant_ht' => $factures->sum('montant_ht'),
            'total_montant_ttc' => $factures->sum('montant_ttc'),
        ]);
    }

    /**
     * Rechercher les factures par client
     */
    public function searchByClient($clientId): JsonResponse
    {
        $factures = Facture::with(['client', 'articles'])
            ->where('client_id', $clientId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $factures,
            'total' => $factures->count(),
            'total_ht' => $factures->sum('montant_ht'),
            'total_ttc' => $factures->sum('montant_ttc'),
        ]);
    }

    /**
     * Rechercher les factures par date
     */
    public function searchByDate($date): JsonResponse
    {
        $factures = Facture::with(['client', 'articles'])
            ->whereDate('date_emission', $date)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $factures,
            'total' => $factures->count(),
            'total_ht' => $factures->sum('montant_ht'),
            'total_ttc' => $factures->sum('montant_ttc'),
        ]);
    }
}
