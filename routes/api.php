<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\FactureController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Routes d'authentification (publiques)
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
});

// Routes protégées par authentification
Route::middleware('auth:sanctum')->group(function () {
    // Récupérer l'utilisateur connecté
    Route::get('/user', [AuthController::class, 'user'])->name('auth.user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Routes pour les clients
    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('clients.index');
        Route::post('/', [ClientController::class, 'store'])->name('clients.store');
        Route::get('/{client}', [ClientController::class, 'show'])->name('clients.show');
        Route::put('/{client}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    });

    // Routes pour les factures
    Route::prefix('factures')->group(function () {
        Route::get('/', [FactureController::class, 'index'])->name('factures.index');
        Route::post('/', [FactureController::class, 'store'])->name('factures.store');
        Route::get('/{facture}', [FactureController::class, 'show'])->name('factures.show');
        Route::put('/{facture}', [FactureController::class, 'update'])->name('factures.update');
        Route::delete('/{facture}', [FactureController::class, 'destroy'])->name('factures.destroy');

        // Export JSON
        Route::get('/export/json', [FactureController::class, 'exportJson'])->name('factures.export.json');

        // Recherche de factures
        Route::get('/search/client/{clientId}', [FactureController::class, 'searchByClient'])->name('factures.search.client');
        Route::get('/search/date/{date}', [FactureController::class, 'searchByDate'])->name('factures.search.date');
    });

    // Route pour exporter toutes les données
    Route::get('/export/complet', [FactureController::class, 'exportComplet'])->name('export.complet');
});
