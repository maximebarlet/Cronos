<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['shipping_date']) && !empty($_POST['shipping_date'])
    && isset($_POST['order_origin']) && !empty($_POST['order_origin'])
    && isset($_POST['order_creation_date']) && !empty($_POST['order_creation_date'])){
        // On inclut la connexion à la base
        require_once('../db.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['id']);
        $shipping_date = strip_tags($_POST['shipping_date']);
        $order_origin = strip_tags($_POST['order_origin']);
        $order_creation_date = strip_tags($_POST['order_creation_date']);

        $sql = 'UPDATE `liste` SET `shipping_date`=:shipping_date, `order_origin`=:order_origin, `order_creation_date`=:order_creation_date WHERE `id`=:id;';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':shipping_date', $shipping_date, PDO::PARAM_STR);
        $query->bindValue(':order_origin', $order_origin, PDO::PARAM_STR);
        $query->bindValue(':order_creation_date', $order_creation_date, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "Produit modifié";
        require_once('close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('../db.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `liste` WHERE `id` = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $produit = $query->fetch();

    // On vérifie si le produit existe
    if(!$produit){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un produit</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <h1>Modifier un produit</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="shipping_date">Date éxpédition</label>
                        <input type="date" id="shipping_date" name="shipping_date" class="form-control" value="<?= $produit['shipping_date']?>">
                    </div>
                    <div class="form-group">
                        <label for="order_origin">Origine commande</label>
                        <input type="text" id="order_origin" name="order_origin" class="form-control" value="<?= $produit['order_origin']?>">

                    </div>
                    <div class="form-group">
                        <label for="order_creation_date">Date de création de la ligne de commande</label>
                        <input type="date" id="order_creation_date" name="order_creation_date" class="form-control" value="<?= $produit['order_creation_date']?>">
                    </div>
                    <input type="hidden" value="<?= $produit['id']?>" name="id">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>