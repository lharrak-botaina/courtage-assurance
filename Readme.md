# Documentation du Projet

## Prérequis

Assurez-vous d'avoir les éléments suivants installés sur votre machine :

- [XAMPP](https://www.apachefriends.org/index.html)
- [Node.js](https://nodejs.org/)
- [Composer](https://getcomposer.org/)
- Symfony CLI

## Démarrage

### Étape 1 : Configurez votre environnement

1. **Configurer la connexion à la base de données :**
   - Localisez le fichier `.env` à la racine de votre projet.
   - Configurez les paramètres de connexion à votre base de données en fonction de votre configuration XAMPP.

### Étape 2 : Installer les dépendances

#### Frontend

Naviguez vers votre répertoire frontend et exécutez les commandes suivantes:

```bash
npm install
npm run dev
 ```
#### Backend
Naviguez vers votre répertoire backend et exécutez les commandes suivantes:
 ```bash
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
symfony console doctrine:fixtures:load
symfony server:start

 ```