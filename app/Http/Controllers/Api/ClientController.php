<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;


class ClientController extends Controller
{
    /**
     * Retourne la liste des clients avec leurs factures
     */
    public function index()
    {
        $clients = Client::with('factures')->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($clients);
    }

    /**
     * Enregistre un nouveau client
     */
    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());

        return response()->json([
            'message' => 'Le client a bien été ajouté.',
            'client'  => $client
        ], 201);
    }

    /**
     * Affiche un client précis
     */
    public function show(Client $client)
    {
        $client->load('factures');

        return response()->json($client);
    }

    /**
     * Met à jour les infos d’un client
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return response()->json([
            'message' => 'Informations du client mises à jour.',
            'client'  => $client
        ]);
    }

    /**
     * Supprime un client
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json([
            'message' => 'Client supprimé avec succès.'
        ]);
    }
}
