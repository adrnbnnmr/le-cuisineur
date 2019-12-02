<?php
require_once 'util/session.php';

require_once 'class/recette.class.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="/css/global.css">
	<title>Le Cuisineur - Erreur 404</title>
</head>

<body>
	<? include_once 'parts/header.php' ?>

	<? // Main content //
	?>
	<section>
		<h1>Erreur 404</h1>
        <p>Cette page n'existe pas !</p>
        <a href="/">Revenir au debut</a>
	</section>
</body>

</html>
