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
Répertoire contenant un script d'installation shell, le fichier docker-compose et les données nécessaires à une initialisation de l'application.

Lors d'une mise à jour ou installation, l'administrateur devra :

Exporter la base de données au besoin (depuis phpPgAdmin par exemple) 

Eteindre les éventuels services
```
docker-compose down
```

Récupérer les données depuis le dépôt git 
```
git pull
```

Donner les droits d'exécution au script d'installation 'install.sh'
```
chmod +x install.sh
```

Exécuter les script 'install.sh' avec les droits root.
```
sudo ./install.sh
```

Lancer l'application avec 
```
docker-compose up
```

Eventuellement réimporter les données précédemment sauvegardées



L'application est accessible à l'adresse [http://localhost:8080](http://localhost:8080). La base de données est accessible sur le port **5432** et l'interface graphique d'administration de la base de données [phpPgAdmin](http://phppgadmin.sourceforge.net/doku.php) est accessible à l'adresse [http://localhost:8081](http://localhost:8081)

## Dictionnaire des donnees 

[Google Sheets avec commentaires](https://docs.google.com/spreadsheets/d/1fnws_vEczwz3d9ZZ9UqP-FuI7gndi-n4DS-rq88Zrps/edit?usp=sharing)

## Modèle entité association

![Alt text](documents/mea.png?raw=true "MEA")

## Modèle relationnel (MLD)

Utilisateur (__uti_login__, uti_mail, uti_nom, uti_prenom, uti_pass, uti_admin, uti_avatar)

Unite (__uni_label__, uni_short_label)

Categorie (__cat_label__, cat_description, cat_illustration)

Recette (__rct_id__, #uti_login, #cat_label, rct_date, rct_titre, rct_description, rct_temps_preparation, rct_temps_cuisson, rct_temps_repos, rct_difficulte, rct_cout, rct_illustration, rct_nb_personnes)

Commentaire (__com_id__, #uti_login, #rct_id, com_texte, com_date)

Ingredient (__igd_label__, #uti_login, igd_description, igd_illustration)

Notation (__#rct_id__, __#uti_login__, note)

Besoin (__#uni_label__, __#igd_label__, __#rct_id__, quantite)

## Contraintes particulières 

Les champs textes uniques (uti_login, cat_label, uni_label) sont uniques sans prendre en compte la casse. 

uti_login peut être composé de lettres, de chiffres ou des caractères ‘_’ et ‘-’.
uti_login a une taille comprise entre 4 et 16 caractères

uti_pass a une taille stricte de 60 caractères.

L'utilisateur doit être administrateur (uti_admin à 'true') pour ajouter un ingrédient.


Hors base de données :

Le mot de passe fait au moins 8 caracteres

## Liste des fonctionnalités (en base de données)

Trois fonctionnalités majeures seront implémentées :
- Le classement des utilisateurs en fonction du nombre de recettes qu'ils postent durant une certaine période
- Le classement des utilisateurs qui mettent le plus de mauvaises notes
- Une suggestion de menu aléatoire (composé d'une entrée, d'un plat et d'un dessert)
