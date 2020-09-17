<?php
session_start();
require 'db.php';
if (isset($_POST['connecter'])) {
	$emailconnect = htmlspecialchars($_POST['emailconnect']);
	$passconnect = sha1($_POST['passconnect']);
	if (!empty($emailconnect) && !empty($passconnect)) {
		$req = $db->prepare("SELECT * FROM membre where email = '$emailconnect' AND pass = '$passconnect'");
		$req->execute(array($emailconnect, $passconnect));
		$resultat = $req->rowCount();
		if ($resultat == 1) {
			$userinfo = $req->fetch();
			$_SESSION['id'] = $userinfo['id'];
			$_SESSION['pseudo'] = $userinfo['pseudo'];
			$_SESSION['email'] = $userinfo['email'];
			header("location: profil.php?id=" . $_SESSION['id']);
		} else {
			$erreur = "Mauvais identifiant ou mot de passe.";
		}
	} else {
		$erreur = "Veuillez remplir tous les champs.";
	}

}

?>

	<?php require 'include/header.php'; ?>
	<!--Formulaire de connexion-->
	<h3>Connexion</h3>

	<!--Affichage des erreurs-->
	<?php
if (isset($erreur)) { //affiche les texte de la variable $erreur.

	echo '<div class="alert alert-danger">' . $erreur . '</div>';
}
?>
		<form action="" method="post">
			<div class="form-group">
				<label for="emailconnect"> Votre identifiant: </label>
				<input type="email" name="emailconnect" id="emailconnect" class="form-control" placeholder="Email">
				<label for="passconnect"> Mot de passe: </label>
				<input type="password" name="passconnect" id="passconnect" class="form-control" placeholder="Mot de passe">
			</div>
			<button type="submit" name="connecter" class="btn btn-default btn-lg btn-block">Se connecter </button>
		</form>

		<?php require 'include/footer.php'; ?>
