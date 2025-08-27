# Module de Facturation Laravel

Un module de facturation complet développé avec Laravel 12 permettant la gestion des clients, l'émission de factures avec calculs automatiques, et l'export des données.

## Fonctionnalités

### ✅ Gestion des Clients
- **Lister les clients** : `GET /api/clients`
- **Créer un client** : `POST /api/clients`
- **Afficher un client** : `GET /api/clients/{id}`
- **Modifier un client** : `PUT /api/clients/{id}`
- **Supprimer un client** : `DELETE /api/clients/{id}`

### ✅ Gestion des Factures
- **Lister les factures** : `GET /api/factures`
- **Créer une facture** : `POST /api/factures`
- **Afficher une facture** : `GET /api/factures/{id}`
- **Modifier une facture** : `PUT /api/factures/{id}`
- **Supprimer une facture** : `DELETE /api/factures/{id}`
- **Rechercher par client** : `GET /api/factures/search/client/{clientId}`
- **Rechercher par date** : `GET /api/factures/search/date/{date}`

### ✅ Export des Données
- **Exporter toutes les factures** : `GET /api/factures/export/json`
- **Export complet (clients + factures)** : `GET /api/export/complet`

### ✅ Authentification (Bonus)
- **Inscription** : `POST /api/auth/register`
- **Connexion** : `POST /api/auth/login`
- **Déconnexion** : `POST /api/auth/logout`
- **Utilisateur connecté** : `GET /api/user`

## Règles Métier

### Validation des Données
- ✅ Une facture doit avoir au moins une ligne
- ✅ Aucun champ ne doit être vide
- ✅ Le taux de TVA doit être 0%, 5.5%, 10% ou 20%

### Calculs Automatiques
- ✅ Total HT : quantité × prix unitaire
- ✅ Total TVA : montant HT × taux TVA
- ✅ Total TTC : montant HT + montant TVA

## Prérequis Techniques

- PHP 8.2+
- Laravel 12+
- SQLite ou PostgreSQL
- Composer

## Installation

1. **Cloner le projet**
   ```bash
   git clone [url-du-repo]
   cd facturation
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   ```

3. **Configurer la base de données**
   ```bash
   cp .env.example .env
   # Configurer DB_CONNECTION=sqlite ou DB_CONNECTION=pgsql
   ```

4. **Générer la clé d'application**
   ```bash
   php artisan key:generate
   ```

5. **Exécuter les migrations**
   ```bash
   php artisan migrate
   ```

6. **Démarrer le serveur**
   ```bash
   php artisan serve
   ```

## Utilisation de l'API

### Authentification

**Inscription :**
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Utilisateur Test",
    "email": "test@example.com",
    "password": "password",
    "password_confirmation": "password"
  }'
```

**Connexion :**
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password"
  }'
```

**Utiliser le token :**
```bash
curl -X GET http://localhost:8000/api/user \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT" \
  -H "Content-Type: application/json"
```

### Gestion des Clients

**Créer un client :**
```bash
curl -X POST http://localhost:8000/api/clients \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Entreprise XYZ",
    "email": "contact@xyz.fr",
    "siret": "12345678901234"
  }'
```

### Gestion des Factures

**Créer une facture :**
```bash
curl -X POST http://localhost:8000/api/factures \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT" \
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

**Rechercher par client :**
```bash
curl -X GET http://localhost:8000/api/factures/search/client/1 \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT"
```

**Rechercher par date :**
```bash
curl -X GET http://localhost:8000/api/factures/search/date/2024-01-15 \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT"
```

### Export des Données

**Exporter les factures :**
```bash
curl -X GET http://localhost:8000/api/factures/export/json \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT"
```

## Structure de la Base de Données

### Clients
- id, nom, email, siret, created_at, updated_at

### Factures  
- id, client_id, numero_facture, date_emission, date_echeance
- montant_ht, montant_tva, montant_ttc, statut, notes

### Facture Articles
- id, facture_id, description, quantite, prix_unitaire
- taux_tva, montant_ht, montant_tva, montant_ttc

## Tests (Bonus)

### Tests Unitaires
Les tests unitaires sont disponibles pour vérifier les fonctionnalités métier :

```bash
php artisan test
```

**Tests inclus :**
- Calculs automatiques des totaux de facture
- Génération de numéros de facture uniques
- Validation des taux de TVA

### Tests d'Authentification
Les tests d'authentification vérifient :
- Inscription d'utilisateur
- Connexion/déconnexion
- Récupération de l'utilisateur connecté

## Technologies Utilisées

- **PHP 8.2+**
- **Laravel 12+**
- **Laravel Sanctum** (Authentification API)
- **SQLite/PostgreSQL**
- **API RESTful**
- **Validation robuste**
- **Architecture MVC**
- **PHPUnit** (Tests unitaires)

## Sécurité

- Authentification par token JWT
- Validation des données d'entrée
- Protection contre les injections SQL
- Gestion sécurisée des mots de passe (hash bcrypt)

