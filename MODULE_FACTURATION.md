# Module de Facturation - Documentation

## Vue d'ensemble
Ce module de facturation complet permet de gérer des clients et leurs factures avec calcul automatique des montants HT, TVA et TTC.

## Structure des tables

### Table `Client` (clients)
- `id` : Identifiant unique
- `name` : Nom du client
- `email` : Email du client
- `siret` : Numéro SIRET
- `adresse` : Adresse du client (optionnel)
- `ville` : Ville du client (optionnel)
- `telephone` : Numéro de téléphone du client (optionnel)
- `created_at` : Date de création
- `updated_at` : Date de mise à jour

### Table `factures` (factures)
- `id` : Identifiant unique
- `client_id` : Référence au client
- `numero_facture` : Numéro unique de facture
- `date_emission` : Date d'émission
- `date_echeance` : Date d'échéance
- `montant_ht` : Montant hors taxes
- `montant_tva` : Montant TVA
- `montant_ttc` : Montant toutes taxes comprises
- `statut` : Statut de la facture (brouillon, envoyée, payée, en retard)
- `notes` : Notes additionnelles

### Table `facture_articles` (invoice items)
- `id` : Identifiant unique
- `facture_id` : Référence à la facture
- `description` : Description de l'article
- `quantite` : Quantité
- `prix_unitaire` : Prix unitaire HT
- `taux_tva` : Taux de TVA en pourcentage
- `montant_ht` : Montant HT pour cet article
- `montant_tva` : Montant TVA pour cet article
- `montant_ttc` : Montant TTC pour cet article

## API Endpoints

### Clients
- `GET /api/clients` - Liste tous les clients
- `POST /api/clients` - Créer un nouveau client
- `GET /api/clients/{id}` - Afficher un client
- `PUT /api/clients/{id}` - Mettre à jour un client
- `DELETE /api/clients/{id}` - Supprimer un client

### Factures
- `GET /api/factures` - Liste toutes les factures
- `POST /api/factures` - Créer une nouvelle facture
- `GET /api/factures/{id}` - Afficher une facture
- `PUT /api/factures/{id}` - Mettre à jour une facture
- `DELETE /api/factures/{id}` - Supprimer une facture

### Export
- `GET /api/factures/export/json` - Exporter toutes les factures en JSON
- `GET /api/export/complet` - Exporter toutes les données (clients + factures)

## Exemples d'utilisation

### Créer un client
```bash
curl -X POST http://localhost:8000/api/clients \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Entreprise XYZ",
    "email": "contact@xyz.fr",
    "siret": "12345678901234"
  }'
```

### Créer une facture
```bash
curl -X POST http://localhost:8000/api/factures \
  -H "Content-Type: application/json" \
  -d '{
    "client_id": 1,
    "date_emission": "2024-01-15",
    "date_echeance": "2024-02-15",
    "notes": "Facture de test",
    "articles": [
      {
        "description": "Service de développement web",
        "quantite": 10,
        "prix_unitaire": 500.00,
        "taux_tva": 20.00
      },
      {
        "description": "Hébergement web",
        "quantite": 1,
        "prix_unitaire": 120.00,
        "taux_tva": 20.00
      }
    ]
  }'
```

### Calcul automatique
Les montants sont calculés automatiquement :
- Montant HT = quantité × prix unitaire
- Montant TVA = montant HT × (taux TVA / 100)
- Montant TTC = montant HT + montant TVA

## Installation
1. Exécuter les migrations : `php artisan migrate`
2. Lancer le serveur : `php artisan serve`
3. Tester les endpoints avec Postman ou curl

## Tests
Pour tester l'API, vous pouvez utiliser les commandes curl fournies ou un outil comme Postman.
