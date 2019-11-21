# PROJET : SITE DE PARTAGE DE RECETTE DE CUISINE

Aujourd'hui, les moyens de diffusion de masse des recettes de cuisine sont verticales : de la TV vers le public, du livre vers la personne, etc.

Ce réseau social permet à n'importe quel amateur de cuisine de partager ses recettes en masse, de manière horizontale et d'accéder à des recettes familiales du monde entier.


## Problématiques
Comment partager des recettes personnelles aux personnes intéressées ?

Comment accéder à une recette pertinente selon ses besoins ?


## Besoins
Le client souhaite partager ses recettes afin de partager son savoir.

Le client souhaite visualiser les recettes d'autres personnes afin d'essayer de nouveaux mets culinaires

Le client souhaite attribuer une note et commenter les recettes d'autres membres afin de donner des conseils ou faire part de sa satisfaction.

Le client souhaite attribuer à une recette afin de faire part de sa satisfaction.

Le client souhaite retrouver facilement des recettes qu'il a déjà utilisé. 


## Solutions
### a. Solutions fonctionnelles
- Un visiteur peut effectuer des recherches avancées sur des recettes 
- Un visiteur peut créer un compte et s'y connecter
- Un utilisateur peut créer, modifier et supprimer ses recettes
- Une recette peut être commentée par les utilisateurs 
- Une recette peut être notée par les utilisateurs
- Une recette indique les ingrédients, leurs quantités et leurs unités de mesure
- Un utilisateur peut supprimer ses propres commentaires
- Un utilisateur peut alimenter une liste de ses recettes favorites
- Un administrateur peut créer, modifier et supprimer un ingrédient
- Un administrateur peut modifier et supprimer n'importe quel commentaire
- Un administrateur peut modifier et supprimer n'importe quelle recette

### b. Solutions techniques
- Base de donnees Postgresql : Permet de stocker les données de l'application. Base de données relationnelle performante et opensource.
- Stack Apache/PHP pour le site Web : Stack la plus classique pour les sites web dynamiques. Correspond parfaitement aux besoins du projet. 
- Docker : Permet d'avoir une configuration commune pour les environnements de développement et de production. Le déploiement de l'application facilité. Docker est le leader du marché, et possède donc le plus grand nombre de ressources techniques dans le monde de la containerization.


## Livrable
Répertoire contenant le script docker-compose et les données nécessaires à une initialisation de l'application.

Lors des mises à jours, l'administrateur du système devra suivre la procédure suivante :

Stopper les services
```
docker-compose down
```

Télécharger les mises à jours
```
git pull
```

Redémarrer les services
```
docker-compose up
```


L'application est accessible à l'adresse [http://localhost:8080](http://localhost:8080). La base de données est accessible sur le port **5432** et l'interface graphique d'administration de la base de données [phpPgAdmin](http://phppgadmin.sourceforge.net/doku.php) est accessible à l'adresse [http://localhost:8081](http://localhost:8081)

## Dictionnaire des donnees 

[Google Sheets avec commentaires](https://docs.google.com/spreadsheets/d/1fnws_vEczwz3d9ZZ9UqP-FuI7gndi-n4DS-rq88Zrps/edit?usp=sharing)

