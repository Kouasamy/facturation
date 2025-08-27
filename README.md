# Module de Facturation Laravel - Documentation Complète

## 📋 Vue d'ensemble

Un module de facturation complet développé avec Laravel 12 permettant la gestion des clients, l'émission de factures avec calculs automatiques, l'export des données et l'authentification sécurisée via API RESTful.

Ce module offre une solution complète pour la gestion de facturation avec une architecture robuste, des validations métier strictes et une interface API complète.

## 🚀 Fonctionnalités

### ✅ Gestion Complète des Clients
- **Lister tous les clients** : `GET /api/clients`
- **Créer un nouveau client** : `POST /api/clients`
- **Afficher un client spécifique** : `GET /api/clients/{id}`
- **Modifier un client existant** : `PUT /api/clients/{id}`
- **Supprimer un client** : `DELETE /api/clients/{id}`

### ✅ Gestion Avancée des Factures
- **Lister toutes les factures** : `GET /api/factures`
- **Créer une nouvelle facture** : `POST /api/factures`
- **Afficher une facture spécifique** : `GET /api/factures/{id}`
- **Modifier une facture existante** : `PUT /api/factures/{id}`
- **Supprimer une facture** : `DELETE /api/factures/{id}`
- **Rechercher par client** : `GET /api/factures/search/client/{clientId}`
- **Rechercher par date** : `GET /api/factures/search/date/{date}`

### ✅ Export des Données
- **Exporter toutes les factures en JSON** : `GET /api/factures/export/json`
- **Export complet (clients + factures)** : `GET /api/export/complet`

### ✅ Authentification Sécurisée (Bonus)
- **Inscription utilisateur** : `POST /api/auth/register`
- **Connexion utilisateur** : `POST /api/auth/login`
- **Déconnexion utilisateur** : `POST /api/auth/logout`
- **Récupérer l'utilisateur connecté** : `GET /api/user`

## 🗄️ Structure de la Base de Données

### Table `clients`
- `id` : Identifiant unique (BigInteger, Auto-increment)
- `name` : Nom du client (String, Requis)
- `email` : Email du client (String, Requis, Unique)
- `siret` : Numéro SIRET (String, Requis, Unique)
- `adresse` : Adresse du client (String, Optionnel)
- `ville` : Ville du client (String, Optionnel)
- `telephone` : Numéro de téléphone (String, Optionnel)
- `created_at` : Date de création (Timestamp)
- `updated_at` : Date de mise à jour (Timestamp)

### Table `factures`
- `id` : Identifiant unique (BigInteger, Auto-increment)
- `client_id` : Référence au client (Foreign Key, Requis)
- `numero_facture` : Numéro unique de facture (String, Requis, Unique)
- `date_emission` : Date d'émission (Date, Requis)
- `date_echeance` : Date d'échéance (Date, Requis)
- `montant_ht` : Montant hors taxes (Decimal, Calculé)
- `montant_tva` : Montant TVA (Decimal, Calculé)
- `montant_ttc` : Montant toutes taxes comprises (Decimal, Calculé)
- `statut` : Statut de la facture (Enum: brouillon, envoyée, payée, en retard)
- `notes` : Notes additionnelles (Text, Optionnel)
- `created_at` : Date de création (Timestamp)
- `updated_at` : Date de mise à jour (Timestamp)

### Table `facture_articles` (Lignes de facture)
- `id` : Identifiant unique (BigInteger, Auto-increment)
- `facture_id` : Référence à la facture (Foreign Key, Requis)
- `description` : Description de l'article (String, Requis)
- `quantite` : Quantité (Integer, Requis, Min: 1)
- `prix_unitaire` : Prix unitaire HT (Decimal, Requis, Min: 0)
- `taux_tva` : Taux de TVA en pourcentage (Decimal, Requis)
- `montant_ht` : Montant HT pour cet article (Decimal, Calculé)
- `montant_tva` : Montant TVA pour cet article (Decimal, Calculé)
- `montant_ttc` : Montant TTC pour cet article (Decimal, Calculé)
- `created_at` : Date de création (Timestamp)
- `updated_at` : Date de mise à jour (Timestamp)

## 🔌 API Endpoints Complets

### Authentification
- **POST /api/auth/register** - Inscription d'un nouvel utilisateur
- **POST /api/auth/login** - Connexion d'un utilisateur
- **POST /api/auth/logout** - Déconnexion
- **GET /api/user** - Récupérer les informations de l'utilisateur connecté

### Clients
- **GET /api/clients** - Liste tous les clients (Authentification requise)
- **POST /api/clients** - Créer un nouveau client (Authentification requise)
- **GET /api/clients/{id}** - Afficher un client spécifique (Authentification requise)
- **PUT /api/clients/{id}** - Mettre à jour un client (Authentification requise)
- **DELETE /api/clients/{id}** - Supprimer un client (Authentification requise)

### Factures
- **GET /api/factures** - Liste toutes les factures (Authentification requise)
- **POST /api/factures** - Créer une nouvelle facture (Authentification requise)
- **GET /api/factures/{id}** - Afficher une facture spécifique (Authentification requise)
- **PUT /api/factures/{id}** - Mettre à jour une facture (Authentification requise)
- **DELETE /api/factures/{id}** - Supprimer une facture (Authentification requise)
- **GET /api/factures/search/client/{clientId}** - Rechercher les factures d'un client (Authentification requise)
- **GET /api/factures/search/date/{date}** - Rechercher les factures par date (Authentification requise)

### Export
- **GET /api/factures/export/json** - Exporter toutes les factures en JSON (Authentification requise)
- **GET /api/export/complet** - Exporter toutes les données (clients + factures) (Authentification requise)

## 🛠️ Installation et Configuration

### Prérequis Techniques
- **PHP 8.2+** avec extensions requises
- **Laravel 12+**
- **SQLite** ou **PostgreSQL** (recommandé)
- **Composer** pour la gestion des dépendances
- **Node.js** (optionnel pour les assets frontend)

### Étapes d'Installation

1. **Cloner le projet**
   ```bash
   git clone [url-du-repo]
   cd facturation
   ```

2. **Installer les dépendances PHP**
   ```bash
   composer install
   ```

3. **Configurer l'environnement**
   ```bash
   cp .env.example .env
   ```

4. **Configurer la base de données**
   Modifier le fichier `.env` :
   ```env
   DB_CONNECTION=sqlite
   # ou
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=facturation
   DB_USERNAME=postgres
   DB_PASSWORD=
   ```

   Pour SQLite, créer le fichier de base de données :
   ```bash
   touch database/database.sqlite
   ```

5. **Générer la clé d'application**
   ```bash
   php artisan key:generate
   ```

6. **Exécuter les migrations**
   ```bash
   php artisan migrate
   ```

7. **Démarrer le serveur de développement**
   ```bash
   php artisan serve
   ```

8. **Installer les dépendances frontend (optionnel)**
   ```bash
   npm install
   npm run dev
   ```

## 🎯 Utilisation de l'API

### Authentification

**Inscription d'un utilisateur :**
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

**Connexion et récupération du token :**
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password"
  }'
```

**Utiliser le token JWT pour les requêtes authentifiées :**
```bash
curl -X GET http://localhost:8000/api/user \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT" \
  -H "Content-Type: application/json"
```

### Gestion des Clients

**Créer un nouveau client :**
```bash
curl -X POST http://localhost:8000/api/clients \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Entreprise XYZ",
    "email": "contact@xyz.fr",
    "siret": "12345678901234",
    "adresse": "123 Rue des Exemples",
    "ville": "Paris",
    "telephone": "0123456789"
  }'
```

**Lister tous les clients :**
```bash
curl -X GET http://localhost:8000/api/clients \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT"
```

### Gestion des Factures

**Créer une facture complète :**
```bash
curl -X POST http://localhost:8000/api/factures \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT" \
  -H "Content-Type: application/json" \
  -d '{
    "client_id": 1,
    "date_emission": "2024-01-15",
    "date_echeance": "2024-02-15",
    "notes": "Facture pour services de développement",
    "articles": [
      {
        "description": "Service de développement web",
        "quantite": 10,
        "prix_unitaire": 500.00,
        "taux_tva": 20.00
      },
      {
        "description": "Hébergement web mensuel",
        "quantite": 1,
        "prix_unitaire": 120.00,
        "taux_tva": 20.00
      },
      {
        "description": "Conseil stratégique",
        "quantite": 5,
        "prix_unitaire": 200.00,
        "taux_tva": 10.00
      }
    ]
  }'
```

**Rechercher les factures d'un client spécifique :**
```bash
curl -X GET http://localhost:8000/api/factures/search/client/1 \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT"
```

**Rechercher les factures par date :**
```bash
curl -X GET http://localhost:8000/api/factures/search/date/2024-01-15 \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT"
```

### Export des Données

**Exporter toutes les factures en JSON :**
```bash
curl -X GET http://localhost:8000/api/factures/export/json \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT"
```

**Export complet (clients + factures) :**
```bash
curl -X GET http://localhost:8000/api/export/complet \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT"
```

## 🧪 Guide de Test avec Postman

### Configuration de Base Postman
1. **URL de base**: `http://127.0.0.1:8000/api`
2. **Serveur Laravel**: Assurez-vous que `php artisan serve` est en cours d'exécution
3. **Environnement**: Créez un environnement Postman avec la variable `base_url`

### Collection Postman Recommandée

**Authentification:**
- **POST** `/auth/register` - Inscription
  ```json
  {
      "name": "Test User",
      "email": "test@example.com",
      "password": "password",
      "password_confirmation": "password"
  }
  ```

- **POST** `/auth/login` - Connexion
  ```json
  {
      "email": "test@example.com",
      "password": "password"
  }
  ```

**Gestion des Clients:**
- **GET** `/clients` - Lister les clients (Header: `Authorization: Bearer {{token}}`)
- **POST** `/clients` - Créer un client
  ```json
  {
      "name": "Entreprise Test",
      "email": "client@test.com",
      "siret": "12345678901234"
  }
  ```
- **GET** `/clients/{id}` - Afficher un client

**Gestion des Factures:**
- **GET** `/factures` - Lister les factures
- **POST** `/factures` - Créer une facture
  ```json
  {
      "client_id": 1,
      "date_emission": "2024-01-15",
      "date_echeance": "2024-02-15",
      "articles": [
          {
              "description": "Service de développement",
              "quantite": 10,
              "prix_unitaire": 100,
              "taux_tva": 20
          },
          {
              "description": "Conseil stratégique",
              "quantite": 5,
              "prix_unitaire": 200,
              "taux_tva": 10
          }
      ]
  }
  ```

**Export:**
- **GET** `/factures/export/json` - Exporter en JSON
- **GET** `/factures/search/client/{clientId}` - Recherche par client
- **GET** `/factures/search/date/{date}` - Recherche par date

### Scénarios de Test Complets

**Tests de Validation Métier:**
1. **Facture sans articles** → Doit échouer avec erreur de validation
2. **Champs obligatoires vides** → Doit échouer avec erreur de validation
3. **Taux TVA invalide** → Doit échouer (seuls 0%, 5.5%, 10%, 20% acceptés)
4. **Quantité négative** → Doit échouer avec erreur de validation
5. **Prix unitaire négatif** → Doit échouer avec erreur de validation

**Tests de Calculs Automatiques:**
1. Vérifier que les totaux HT sont calculés correctement
2. Vérifier que les montants TVA sont calculés correctement
3. Vérifier que les totaux TTC sont calculés correctement
4. Vérifier la cohérence entre les totaux de la facture et la somme des articles

**Tests d'Authentification:**
1. Accès aux endpoints sans token → Doit échouer avec erreur 401
2. Accès avec token invalide → Doit échouer avec erreur 401
3. Accès avec token valide → Doit réussir

## 📊 Règles Métier et Validation

### Validation des Données
- ✅ **Facture doit avoir au moins une ligne** - Une facture ne peut pas être créée sans articles
- ✅ **Aucun champ obligatoire ne doit être vide** - Tous les champs marqués comme requis doivent être fournis
- ✅ **Taux de TVA valides** - Seuls les taux 0%, 5.5%, 10% et 20% sont acceptés
- ✅ **Quantité positive** - La quantité doit être un entier positif (≥1)
- ✅ **Prix unitaire positif** - Le prix unitaire doit être un nombre positif (≥0)
- ✅ **Email valide** - Les adresses email doivent être au format valide
- ✅ **SIRET unique** - Le numéro SIRET doit être unique parmi tous les clients
- ✅ **Numéro de facture unique** - Chaque facture doit avoir un numéro unique

### Calculs Automatiques

**Pour chaque article:**
- **Montant HT** = `quantité × prix unitaire`
- **Montant TVA** = `montant HT × (taux TVA / 100)`
- **Montant TTC** = `montant HT + montant TVA`

**Pour la facture entière:**
- **Total HT** = `∑(montant HT de tous les articles)`
- **Total TVA** = `∑(montant TVA de tous les articles)`
- **Total TTC** = `∑(montant TTC de tous les articles)` ou `Total HT + Total TVA`

**Exemple de calcul:**
- Article: 10 unités × 100€ HT + TVA 20%
- Montant HT = 10 × 100 = 1 000€
- Montant TVA = 1 000 × 0.20 = 200€
- Montant TTC = 1 000 + 200 = 1 200€

## 🧪 Tests Unitaires

### Exécution des Tests
```bash
php artisan test
```

### Tests Implémentés

**Tests de Calcul:**
- Vérification des calculs automatiques des totaux de facture
- Tests des différents taux de TVA (0%, 5.5%, 10%, 20%)
- Vérification de la cohérence des calculs

**Tests de Validation:**
- Validation des données d'entrée des clients
- Validation des données d'entrée des factures
- Validation des articles de facture

**Tests d'Authentification:**
- Inscription d'utilisateur
- Connexion/déconnexion
- Récupération de l'utilisateur connecté
- Protection des endpoints authentifiés

**Tests de Génération:**
- Génération de numéros de facture uniques
- Vérification de l'unicité des contraintes

## 🔒 Sécurité

### Mesures de Sécurité Implémentées
- **Authentification par token JWT** via Laravel Sanctum
- **Validation robuste** des données d'entrée
- **Protection contre les injections SQL** grâce à l'ORM Eloquent
- **Gestion sécurisée des mots de passe** avec hash bcrypt
- **Protection CSRF** pour les requêtes web
- **Validation des taux TVA** pour prévenir les erreurs de calcul
- **Contrôle d'accès** basé sur l'authentification

### Bonnes Pratiques de Sécurité
- Utilisation de tokens d'authentification avec expiration
- Validation de tous les champs d'entrée
- Hashage des mots de passe avec bcrypt
- Utilisation de requêtes préparées
- Protection contre les attaques XSS
- Gestion sécurisée des erreurs

## 🛠️ Technologies Utilisées

### Backend
- **PHP 8.2+** - Langage de programmation
- **Laravel 12+** - Framework PHP moderne
- **Laravel Sanctum** - Authentification API
- **Eloquent ORM** - ORM pour la base de données
- **PHPUnit** - Framework de tests unitaires

### Base de Données
- **SQLite** - Base de données légère (développement)
- **PostgreSQL** - Base de données relationnelle (production)
- **Migrations Laravel** - Gestion du schéma de base de données

### Outils de Développement
- **Composer** - Gestionnaire de dépendances PHP
- **Artisan** - CLI de Laravel
- **Postman** - Test et documentation d'API

### Sécurité
- **JWT Tokens** - Authentification stateless
- **BCrypt** - Hashage des mots de passe
- **Validation Laravel** - Validation des données

## 📈 Architecture

### Pattern MVC
- **Modèles** - Représentent les données (Client, Facture, FactureArticle, User)
- **Vues** - Interface utilisateur (Blade templates)
- **Contrôleurs** - Gèrent la logique métier (AuthController, ClientController, FactureController)

### API RESTful
- Endpoints standards REST
- Codes HTTP appropriés
- Format JSON pour toutes les réponses
- Authentification stateless

### Validation des Données
- Form Requests Laravel pour la validation
- Règles métier personnalisées
- Messages d'erreur descriptifs


## 🤝 Contribution

### Guidelines de Développement
1. Suivre les standards PSR
2. Écrire des tests unitaires pour les nouvelles fonctionnalités
3. Documenter les nouvelles API endpoints
4. Vérifier la validation des données
5. Tester les calculs automatiques

### Structure du Code
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── AuthController.php
│   │   │   ├── ClientController.php
│   │   │   └── FactureController.php
│   │   └── Controller.php
│   └── Requests/
│       ├── StoreClientRequest.php
│       ├── StoreFactureRequest.php
│       ├── UpdateClientRequest.php
│       └── UpdateFactureRequest.php
├── Models/
│   ├── Client.php
│   ├── Facture.php
│   ├── FactureArticle.php
│   └── User.php
└── Providers/
```
