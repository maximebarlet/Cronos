<?php
require 'db.php';// Connexion à la base de données
if (isset($_POST['validation'])) {
    if (!empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['password-confirm'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $password = sha1($_POST['password']);
        $passwordConfirm = sha1($_POST['password-confirm']);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $req = $db->query("SELECT pseudo FROM membre WHERE pseudo = '$pseudo'"); // On sélectionne le champ (pseudo) dans notre table membre où pseudo est égale au champ pseudo rentré par l'utilisateur
            $countpseudo = $req->rowCount(); // on rowCount() la requete, donc rowcount retournera une valeur si il trouve.
            if ($countpseudo == 0 ) { // si il ne trouve pas une valeur, alors c'est bon
                $req = $db->query("SELECT email FROM membre WHERE email = '$email'");
                $countemail = $req->rowCount();
                if ($countemail == 0 ) {

                    if ($password == $passwordConfirm) {

                        $req = $db->prepare("INSERT INTO membre(pseudo, pass, email, date_inscription) VALUES('$pseudo', '$password', '$email', CURDATE())");
                            $req->execute(array(
                                'pseudo' => $pseudo,
                                'pass' => $password,
                                'email' => $email
                            ));
                        $reussi = "Votre compte à bien été créé. <a href =\"login.php\">Me connecter";
                    } else {
                        $erreur = 'Les mots de passe ne sont pas identiques.';
                    }
                } else {
                        $erreur = 'Cet adresse email est déjà utilisé.';
                }
            } else {
                $erreur = 'L\'identifiant ' .$pseudo. ' est déjà utilisé.';
            }
        } else {
            $erreur = "Veuillez entrer une adresse email valide.";
        }
    } else {
        $erreur = "Tous les champs doivent êtres remplis";
    }
}

?>
    <!--Formulaire d'inscription-->
    <?php require 'include/header.php'; ?>
    <?php
    if (isset($erreur)) { //affiche les texte de la variable $erreur.
        echo '<div class="alert alert-danger">'.$erreur.'</div>';
    } else {
        if (isset($reussi)) {
            echo '<div class="alert alert-success">'.$reussi.'</div>';

        }
    }
?>
        <form action="" method="post">
            <div class="form-group">
                <label for="pseudo">Votre identifiant </label>
                <input type="text" name="pseudo" id="pseudo" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Votre adresse e-mail </label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Votre mot de passe </label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="password-confirm">Confirmez votre mot de passe </label>
                <input type="password" name="password-confirm" id="password-confirm" class="form-control">
            </div>
            <button type="submit" name="validation" class="btn btn-default btn-lg btn-block">S'inscrire </button>
        </form>

        <?php require 'include/footer.php'; ?>
