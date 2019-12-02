<?php

require_once 'class/recette.class.php';
require_once 'class/utilisateur.class.php';
require_once 'util/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="/css/global.css">
	<title>Le Cuisineur - Accueil</title>
</head>

<body>
	<? include_once 'parts/header.php' ?>

	<? if (key_exists("utilisateur", $_SESSION)) : ?>
		<div>Bienvenue, <?= $_SESSION["utilisateur"] ?></div>
	<? endif; ?>

	<section>
		<h1>Le Cuisineur</h1>
		<p> Bienvenue sur Le Cuisineur, premier reseau social de partage de recettes de cuisine.
			<br>
			Sur ce site, vous pourrez chercher des recettes qui vous correspondent vraiment et partager les votres avec le monde entier !
		</p>
		<div>
			<a href="/connexion">Se connecter</a>
			<a href="/inscription">S'inscrire</a>
			<a href="/recettes">Rechercher une recette</a>
		</div>
	</section>

	<? // Suggestion de menu
	?>
	<article class="menu_aleatoire">
		<?= Recette::get_random_recette('Entrée')->to_info_HTML() ?>
		<?= Recette::get_random_recette('Plat')->to_info_HTML() ?>
		<?= Recette::get_random_recette('Dessert')->to_info_HTML() ?>
	</article>
	<? //endmain
	?>
</body>

</html>