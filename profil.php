<?php

require 'db.php';
if (isset($_GET['id']) AND $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $req = $db->prepare('SELECT * FROM membre WHERE id = ?');
  $req->execute(array($getid));
  $userinfo = $req->fetch();

?>

    <?php require 'include/headerLog.php'; ?>

    <h2>Profil de
        <?php echo $userinfo['pseudo']; ?>
    </h2>
    <br />
    <p>Pseudo :
        <?php echo $userinfo['pseudo']; ?>
    </p>
    <br />

    <p>Votre adresse email est :
        <?php echo $userinfo['email']; ?>
    </p>
    <br />

    <p>Vous êtes inscrit depuis le :
        <?php echo $userinfo['date_inscription']; ?>
    </p>
    <br />


        <?php
} else {
    echo 'Erreur';
}
?>
            <?php require 'include/footer.php'; ?>
