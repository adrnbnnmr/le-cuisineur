# PROJET : SITE DE PARTAGE DE RECETTE DE CUISINE

Aujourd'hui, les moyens de diffusion de masse des recettes de cuisine sont verticales : de la TV vers le public, du livre vers la personne, etc. 
Ce reseau social permet a n'importe quel amateur de cuisine de partager ses recettes en masse, de maniere horizontale et d'acceder a des recettes familiales du monde entier.


## Problematiques
Comment partager des recettes personnelles aux personnes intéressées ?
Comment accéder à une recette pertinente selon ses besoin ?


## Besoins
Le client souhaite partager ses recettes afin de partager son savoir.
Le client souhaite visualiser les recettes d'autres personnes afin d'essayer de nouveaux mets culinaires.
Le client souhaite commenter les recettes d'autres membres afin de donner des conseils ou faire part de sa satisfaction.
Le client souhaite attribuer une note a une recette afin de faire part de sa satisfaction.
Le client souhaite retrouver facilement des recettes qu'il a déjà utilisé. 


## Solutions
### a. Solutions fonctionnelles
- Un visiteur peut effectuer des recherches avancées sur des recettes 
- Un visiteur peut créer un compte et s'y connecter
- Un utilisateur peut créer, modifier et supprimer ses recettes
- Une recette est peut être commentée par les utilisateurs 
- Une recette est notée par les utilisateurs
- Une recette indique les ingrédients, leurs quantités et leurs unités de mesure
- Un utilisateur peut supprimer ses propres commentaires
- Un utilisateur peut alimenter une liste de ses recettes favorites
- Un administrateur peut créer, modifier et supprimer un ingrédient
- Un administrateur peut modifier et supprimer n'importe quel commentaire
- Un administrateur peut modifier et supprimer n'importe quelle recette

### b. Solutions techniques
- Base de donnees Postgresql : Permet de stocker les données de l'application.  
- Stack Apache/PHP pour le site Web : Stack classique pour les sites web dynamiques
- Docker : Permet d'avoir une configuration commune pour les environnements de développement et de production. Déploiement de l'application facilité.


## Livrable
Répertoire contenant le script docker-compose et les données nécessaires à une initialisation de l'application.

### Execution du projet
Dans le repertoire principal, exécuter la commande :
```
docker-compose up
```

L'application est accessible à l'adresse [http://localhost:8080](http://localhost:8080). La base de données est accessible sur le port **5432** et l'interface graphique d'administration de la base de données [phpPgAdmin](http://phppgadmin.sourceforge.net/doku.php) est accessible à l'adresse [http://localhost:8081](http://localhost:8081)

