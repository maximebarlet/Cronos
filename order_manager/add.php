<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['shipping_date']) && !empty($_POST['shipping_date'])
    && isset($_POST['order_origin']) && !empty($_POST['order_origin'])
    && isset($_POST['order_creation_date']) && !empty($_POST['order_creation_date'])){
        // On inclut la connexion à la base
        require_once('../db.php');

        // On nettoie les données envoyées
        $shipping_date = strip_tags($_POST['shipping_date']);
        $order_origin = strip_tags($_POST['order_origin']);
        $order_creation_date = strip_tags($_POST['order_creation_date']);

        $sql = 'INSERT INTO `liste` (`shipping_date`, `order_origin`, `order_creation_date`) VALUES (:shipping_date, :order_origin, :order_creation_date);';

        $query = $db->prepare($sql);

        $query->bindValue(':shipping_date', $shipping_date->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $query->bindValue(':order_origin', $order_origin, PDO::PARAM_STR);
        $query->bindValue(':order_creation_date', $order_creation_date->format('Y-m-d H:i:s'), PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "Produit ajouté";
        require_once('close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>

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
                <h1>Ajouter un produit</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="shipping_date">Date éxpédition</label>
                        <input type="date" id="shipping_date" name="shipping_date" class="form-control" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
                    </div>
                    <div class="form-group">
                        <label for="order_origin">Origine commande</label>
                        <input type="text" id="order_origin" name="order_origin" class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="order_creation_date">Date de création de la ligne de commande</label>
                        <input type="date" id="order_creation_date" name="order_creation_date" class="form-control" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
                    </div>

                    <button class="btn btn-primary">Envoyer</button>

                </form>
            </section>
        </div>
    </main>
</body>
</html>