# 🦁 Arcadia Zoo

Application web de gestion de zoo développée avec Symfony 7.2 et Docker. Cette application permet de gérer les animaux, leurs habitats et les informations vétérinaires.

## Prérequis

- Docker Desktop
- Git

## Fichiers à partager

Pour partager le projet, incluez les éléments suivants :

```
AR_Zoo/
├── .docker/                # Configuration Docker
│   ├── mysql/
│   │   └── init.sql      # Script d'initialisation de la base de données
│   └── php/
│       └── Dockerfile    # Configuration PHP
├── app/
│   ├── config/           # Configuration Symfony
│   ├── migrations/       # Migrations de base de données
│   ├── public/
│   │   └── assets/      # Images et vidéos
│   ├── src/             # Code source
│   ├── templates/       # Templates Twig
│   ├── .env            # Configuration par défaut
│   └── composer.json    # Dépendances du projet
├── .env                  # Configuration Docker
└── docker-compose.yml    # Configuration des conteneurs

Fichiers à exclure :
- app/vendor/           # Sera installé automatiquement
- app/var/             # Dossier de cache
- .docker/mysql/data/  # Données de la base
```

## Installation

1. Clonez le repository :

```bash
git clone <votre-repo>
cd AR_Zoo
```

2. Construisez les images Docker :

```bash
docker-compose build
```

3. Lancez l'application :

```bash
docker-compose up -d
```

4. Configurez les permissions :

```bash
docker-compose exec php chmod -R 777 var/
docker-compose exec php chmod -R 777 public/assets
```

Note importante : La base de données est automatiquement initialisée avec les tables et les données de test via le fichier `.docker/mysql/init.sql`. Il n'est pas nécessaire d'exécuter les migrations Doctrine.

## Accès

- Application : [http://localhost:8000](http://localhost:8000)
- PhpMyAdmin : [http://localhost:8080](http://localhost:8080)
  - Utilisateur : root
  - Mot de passe : root

## Commandes utiles

```bash
# Arrêter l'application
docker-compose down

# Voir les logs
docker-compose logs -f

# Accéder au shell PHP
docker-compose exec php bash

# Vider le cache Symfony
docker-compose exec php php bin/console cache:clear
```

## Structure du projet

```
AR_Zoo/
├── .docker/                # Configuration Docker
│   ├── mysql/             # MySQL (données et init)
│   └── php/              # Configuration PHP
├── app/                   # Application Symfony
│   ├── public/           # Assets publics
│   ├── src/             # Code source
│   └── templates/       # Templates Twig
├── .env                  # Configuration environnement
└── docker-compose.yml    # Configuration Docker
```

## Résolution des problèmes

1. **Erreur de permissions** :

```bash
docker-compose exec php chmod -R 777 var/
```

2. **Images non visibles** :

```bash
docker-compose exec php chmod -R 777 public/assets
```

3. **Réinitialiser la base de données** :
   Pour réinitialiser complètement la base de données avec les données initiales :

```bash
# Arrêter les conteneurs
docker-compose down -v

# Supprimer le dossier de données MySQL
rm -rf .docker/mysql/data

# Redémarrer les conteneurs
docker-compose up -d
```

Note : la structure de la base de données est gérée par le fichier init.sql.

## Sécurité

Les identifiants actuels sont pour le développement uniquement. En production, utilisez des identifiants sécurisés.

## Fonctionnalités

- Gestion des animaux (CRUD)
- Gestion des habitats
- Suivi vétérinaire
- Interface responsive
- Galerie d'images

## Licence

Ce projet est sous licence MIT.
