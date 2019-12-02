-----------------     BDD - Le Cuisineur   -----------------
----------------- version 21 Novembre 2019 -----------------
-----------------------------------------------------------------------------
-- Clear previous information.
-----------------------------------------------------------------------------

DROP TABLE IF EXISTS UTILISATEUR CASCADE;

DROP TABLE IF EXISTS UNITE CASCADE;

DROP TABLE IF EXISTS CATEGORIE CASCADE;

DROP TABLE IF EXISTS RECETTE CASCADE;

DROP TABLE IF EXISTS COMMENTAIRE;

DROP TABLE IF EXISTS INGREDIENT;

DROP TABLE IF EXISTS NOTATION;

DROP TABLE IF EXISTS BESOIN;

---------------------
CREATE OR REPLACE PROCEDURAL
LANGUAGE plpgsql;

-- CREATE USER CUISINEUR;
-- CREATE DATABASE LECUISINEUR;
-- GRANT ALL PRIVILEGES ON DATABASE LECUISINEUR TO CUISINEUR;

\c lecuisineur;
CREATE TABLE UTILISATEUR (
    uti_login VARCHAR(16) UNIQUE NOT NULL, -- Login d’un utilisateur
    uti_mail VARCHAR(254) UNIQUE NOT NULL, -- Email d’un utilisateur, email valide selon RFC5321: 64 char max avant @, 254 char max au total
    uti_nom VARCHAR(32) NOT NULL, -- Nom de l’utilisateur
    uti_prenom VARCHAR(32) NOT NULL, -- Prenom de l’utilisateur
    uti_pass VARCHAR(60) NOT NULL, -- Hash du mot de passe de l’utilisateur (voir php password_hash)
    uti_admin BOOLEAN DEFAULT FALSE NOT NULL, -- Defini si l’utilisateur est un administrateur ou non
    CONSTRAINT PK_UTILISATEUR PRIMARY KEY (uti_login),
    CONSTRAINT CHK_UTILISATEUR_MAIL CHECK (((uti_mail)::text ~* '^[0-9a-zA-Z._-]{1,64}@[0-9a-zA-Z._-]{2,}[.][a-zA-Z]{2,4}$'::text)),
    CONSTRAINT CHK_UTILISATEUR_LOGIN CHECK (((uti_login)::text ~* '^[0-9a-zA-Z\_\-._-]{4,16}$'::text)) -- chiffre, lettre, _, -
);

CREATE TABLE UNITE (
    uni_label VARCHAR(32) UNIQUE NOT NULL, -- Nom de l’unite de mesure en toute lettre
    uni_short_label VARCHAR(16) NOT NULL, -- Unite de mesure sous forme simplifiee -- ex: kg
    CONSTRAINT PK_UNITE PRIMARY KEY (uni_label)
);

CREATE TABLE CATEGORIE (
    cat_label VARCHAR(64) UNIQUE NOT NULL, -- Nom de la categorie
    cat_description VARCHAR(1024) NOT NULL, -- Description de la categorie
    cat_illustration VARCHAR(128) UNIQUE NOT NULL, -- Nom de fichier avec extension de l’image de la categorie
    CONSTRAINT PK_CATEGORIE PRIMARY KEY (cat_label)
);

CREATE TABLE RECETTE (
    rct_id SMALLSERIAL UNIQUE NOT NULL, -- id unique d’une recette
    rct_date TIMESTAMP DEFAULT NOW() NOT NULL, -- date et heure de la recette
    rct_titre VARCHAR(64) NOT NULL, -- Titre de la recette
    rct_description TEXT NOT NULL, -- Description de la recette – contient les etapes, etc
    rct_temps_preparation SMALLINT DEFAULT 0 NOT NULL, -- Temps de preparation en minute
    rct_temps_cuisson SMALLINT DEFAULT 0 NOT NULL, -- Temps de cuisson en minute
    rct_temps_repos SMALLINT DEFAULT 0 NOT NULL, -- Temps de repos en minute
    rct_difficulte SMALLINT DEFAULT 0 NOT NULL, -- Note de difficulte de la recette
    rct_cout SMALLINT DEFAULT 0 NOT NULL, -- Cout : 1 - bon marche, 2 - moyen, 3 - assez cher
    rct_illustration VARCHAR(128) NOT NULL, -- Nom de fichier avec extension de l’image de la recette
    rct_nb_personnes SMALLINT DEFAULT 1 NOT NULL, -- Nombre de personne pour la recette originale
    rct_note SMALLINT DEFAULT 1 NOT NULL, -- Calcule: ensemble des notes de la recette
    cat_label VARCHAR(64) NOT NULL, -- Une recette appartient a une categorie
    uti_login VARCHAR(16) NOT NULL, -- Une recette est ecrite par un utilisateur
    CONSTRAINT PK_RECETTE PRIMARY KEY (rct_id),
    CONSTRAINT FK_RECETTE_CATEGORIE FOREIGN KEY (cat_label) REFERENCES CATEGORIE (cat_label),
    CONSTRAINT FK_RECETTE_UTILISATEUR FOREIGN KEY (uti_login) REFERENCES UTILISATEUR (uti_login),
    CONSTRAINT CK_RECETTE_DIFFICULTE CHECK (rct_difficulte BETWEEN 1 AND 5),
    CONSTRAINT CK_RECETTE_COUT CHECK (rct_cout BETWEEN 1 AND 3),
    CONSTRAINT CK_RECETTE_NOTE CHECK (rct_note BETWEEN 1 AND 5)
);

CREATE TABLE COMMENTAIRE (
    com_id SMALLSERIAL UNIQUE NOT NULL, -- Identifiant unique d’un commentaire
    com_texte VARCHAR(280) NOT NULL, -- Commentaire sur une recette par un utilisateur
    com_date TIMESTAMP DEFAULT NOW() NOT NULL, -- Date et heure de la publication du commentaire
    uti_login VARCHAR(16) NOT NULL, -- Un commentaire a un auteur
    rct_id SMALLINT NOT NULL, -- Un commentaire est publie sur une recette
    CONSTRAINT PK_COMMENTAIRE PRIMARY KEY (com_id),
    CONSTRAINT FK_COMMENTAIRE_UTILISATEUR FOREIGN KEY (uti_login) REFERENCES UTILISATEUR (uti_login),
    CONSTRAINT FK_COMMENTAIRE_RECETTE FOREIGN KEY (rct_id) REFERENCES RECETTE (rct_id)
);

CREATE TABLE INGREDIENT (
    igd_label VARCHAR(64) UNIQUE NOT NULL, -- Nom de l’ingredient
    igd_description VARCHAR(1024) NOT NULL, -- Description de l’ingredient
    igd_illustration VARCHAR(128) UNIQUE NOT NULL, -- Nom de fichier avec extension de l’image de l’ingredient
    uti_login VARCHAR(16) NOT NULL, -- Login d’un utilisateur
    CONSTRAINT PK_INGREDIENT PRIMARY KEY (igd_label),
    CONSTRAINT FK_INGREDIENT_UTILISATEUR FOREIGN KEY (uti_login) REFERENCES UTILISATEUR (uti_login)
);

CREATE TABLE NOTATION (
    rct_id SMALLINT NOT NULL, -- id unique d’une recette
    uti_login VARCHAR(16) NOT NULL, -- Login d’un utilisateur
    note SMALLINT NOT NULL, -- Note attribuee a une recette par un utilisateur
    CONSTRAINT PK_NOTATION PRIMARY KEY (rct_id, uti_login),
    CONSTRAINT FK_NOTATION_RECETTE FOREIGN KEY (rct_id) REFERENCES RECETTE (rct_id),
    CONSTRAINT FK_NOTATIONS_UTILISATEUR FOREIGN KEY (uti_login) REFERENCES UTILISATEUR (uti_login)
);

CREATE TABLE BESOIN (
    rct_id SMALLINT NOT NULL, -- id unique d’une recette
    uni_label VARCHAR(16) NOT NULL, -- Nom de l’unite de mesure en toute lettre
    igd_label VARCHAR(64) NOT NULL, -- Nom de l’ingredient
    quantite NUMERIC(9, 1) NOT NULL, -- Quantite d’un ingredient dans une recette (sans unite)
    CONSTRAINT PK_BESOIN PRIMARY KEY (rct_id, uni_label, igd_label),
    CONSTRAINT FK_BESOIN_RECETTE FOREIGN KEY (rct_id) REFERENCES RECETTE (rct_id),
    CONSTRAINT FK_BESOIN_UNITE FOREIGN KEY (uni_label) REFERENCES UNITE (uni_label),
    CONSTRAINT FK_BESOIN_INGREDIENT FOREIGN KEY (igd_label) REFERENCES INGREDIENT (igd_label)
);

-----



-------------- Insertion de données pour les tests ----------
INSERT INTO UNITE (uni_label, uni_short_label)
VALUES
    ('Cuillère à café', 'C.à.C'),
    ('Cuillère à soupe', 'C.à.S'),
    ('Kilogramme', 'Kg'),
    ('Gramme', 'g'),
    ('Litre', 'L'),
    ('Millilitre', 'mL'),
    ('Unité', '');

INSERT INTO UTILISATEUR (uti_login, uti_mail, uti_nom, uti_prenom, uti_pass, uti_admin)
VALUES
    ('Chaumz', 'test@test.fr', 'chaumard', 'bastien', '', DEFAULT),
    ('mamiesupernova', 'mamie@supernova.fr', 'mamie', 'supernova', '', DEFAULT);

INSERT INTO INGREDIENT (igd_label, igd_description, igd_illustration, uti_login)
VALUES
    ('citron', 'fruit jaune et acide', 'citron.jpg', 'Chaumz'),
    ('asperge', 'légume detox poussant sous terre', 'asperge.jpg', 'Chaumz'),
    ('basilic', 'herbe aromatique délicatement parfumée', 'basilic.jpg', 'Chaumz'),
    ('chocolat', 'inutile de le presenter !', 'chocolat.jpg', 'Chaumz'),
    ('dinde', 'viande blanche et charnue', 'dinde.jpg', 'Chaumz'),
    ('estragon', 'herbe aromatique', 'estragon.jpg', 'Chaumz'),
    ('fraise', 'fruit rouge gorgé de sucre', 'fraise.jpg', 'Chaumz'),
    ('girolle', 'champignon apprécié des connaisseurs', 'girolle.jpg', 'Chaumz'),
    ('homard', 'crustacé raffiné', 'homard.jpg', 'Chaumz'),
    ('lait', 'liquide d origine animale', 'lait.jpg', 'Chaumz'),
    ('myrtille', 'fruit bleu d été', 'myrtille.jpg', 'Chaumz'),
    ('noix', 'fruit à coque plein de vertus', 'noix.jpg', 'Chaumz'),
    ('oignon', 'condiment utilisé dans beaucoup de plats salés', 'oignon.jpg', 'Chaumz'),
    ('pomme de terre', 'tubercule bon marché et nourissant', 'pommedeterre.jpg', 'Chaumz'),
    ('romarin', 'herbe aromatique provençale', 'romarin.jpg', 'Chaumz'),
    ('saumon', 'poisson gras à chair rouge', 'saumon.jpg', 'Chaumz'),
    ('truffe', 'champignon rare et cher', 'truffe.jpg', 'Chaumz'),
    ('violette', 'fleur', 'violette.jpg', 'Chaumz'),
    ('sucre', 'extrêmement sucré', 'sucre.jpg', 'Chaumz');

INSERT INTO CATEGORIE (cat_label, cat_description, cat_illustration)
VALUES
    ('Entrée', 'Rien de tel qu une bonne entree pour mettre l eau à la bouche', 'entree.jpg'),
    ('Plat', 'Copieux ou léger, l important est de se regaler', 'plat.jpg'),
    ('Dessert', 'Les gourmands seront ravis', 'dessert.jpg'),
    ('Apéritif', 'Faites festoyer votre panse', 'aperitif.jpg'),
    ('En-cas', 'Pour les petits creux', 'encas.jpg');

INSERT INTO RECETTE ( 
    rct_titre,
    rct_description,
    rct_temps_preparation,
    rct_temps_cuisson,
    rct_temps_repos,
    rct_difficulte,
    rct_cout,
    rct_illustration,
    rct_nb_personnes,
    rct_note,
    cat_label,
    uti_login
    ) VALUES 
    ('Blinis facile maison', '', 5, 20, 0, 1, 1, '', 4, 5, 'Entrée', 'mamiesupernova'),
    ('Quiche tatin', '', 15, 30, 10, 1, 1, '', 6, 4, 'Entrée', 'mamiesupernova'),
    ('Nems (frits)', '', 45, 50, 5, 3, 2, '', 6, 5, 'Entrée', 'Chaumz'),
    ('Riz', '', 2, 13, 0, 1, 1,  '', 1, 1, 'Plat', 'Chaumz'),
    ('Boeuf de Kobe et ses accompagnements', '', 15, 1, 0, 2, 3, '', 2, 5, 'Plat', 'mamiesupernova'),
    ('Pomme', '', 0, 0, 0, 1, 1, '', 1, 1, 'Dessert', 'Chaumz'),
    ('Tiramisu', '', 15, 0, 0, 1, 1, '', 2, 5, 'Dessert', 'mamiesupernova');
     

