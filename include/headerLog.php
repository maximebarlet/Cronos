<?php
session_start();
require 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">

	<title>Cronos | Outil de gestion de commande</title>

	<!-- Bootstrap core CSS -->
	<link href="css/app.css" rel="stylesheet">
</head>

<body>

	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
				<a class="navbar-brand" href="#">Cronos <span class="version">alpha 0.1</span></a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">

					<li><a href="tools_summary.php">Mes outils</a></li>
                  <?php
                  if (isset($_SESSION['id']) == $_SESSION['id']) {
                      echo '<li><a href="profil.php?id=' . $_SESSION['id'] . '">Mes infos</a></li>' ?>
                      <li><a href="profilModifier.php">Editer mon profil</a></li>
                      <li><a href="logout.php">Se déconnecter</a></li>
                    <?php
                  }
                  ?>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container">
