# Guide de Test API avec Postman

## Configuration de Base
1. **URL de base**: `http://127.0.0.1:8000/api`
2. **Serveur Laravel**: Assurez-vous que `php artisan serve` est en cours d'exécution

## Endpoints à Tester

### 1. Authentification

**Inscription**
- **Méthode**: POST
- **URL**: `/auth/register`
- **Body** (JSON):
```json
{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

**Connexion**
- **Méthode**: POST
- **URL**: `/auth/login`
- **Body** (JSON):
```json
{
    "email": "test@example.com",
    "password": "password"
}
```

**Récupérer le token** depuis la réponse et l'ajouter aux headers suivants :
- **Header**: `Authorization: Bearer {votre_token}`

### 2. Gestion des Clients

**Lister les clients**
- **Méthode**: GET
- **URL**: `/clients`
- **Headers**: Authorization avec token

**Créer un client**
- **Méthode**: POST
- **URL**: `/clients`
- **Body** (JSON):
```json
{
    "nom": "Entreprise Test",
    "email": "client@test.com",
    "siret": "12345678901234"
}
```

**Afficher un client**
- **Méthode**: GET
- **URL**: `/clients/{id}`

### 3. Gestion des Factures

**Lister les factures**
- **Méthode**: GET
- **URL**: `/factures`

**Créer une facture**
- **Méthode**: POST
- **URL**: `/factures`
- **Body** (JSON):
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

**Exporter en JSON**
- **Méthode**: GET
- **URL**: `/factures/export/json`

**Recherche par client**
- **Méthode**: GET
- **URL**: `/factures/search/client/{clientId}`

**Recherche par date**
- **Méthode**: GET
- **URL**: `/factures/search/date/{date}`

### 4. Tests de Validation

**Test des règles métier**:
1. Facture sans articles → doit échouer
2. Champs vides → doit échouer
3. Taux TVA invalide → doit échauter
4. Calculs automatiques → doivent être corrects

## Collection Postman

Vous pouvez créer une collection Postman avec tous ces endpoints pour tester facilement l'ensemble de l'API.

## Tests Unitaires (Bonus)

Pour tester avec PHPUnit :
```bash
php artisan test
```

Les tests vérifieront :
- La création de clients
- La création de factures avec calculs
- Les règles de validation
- Les exports JSON
