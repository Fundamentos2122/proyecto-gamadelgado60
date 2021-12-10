<?php
    //verificar que el usuario este logueado
    session_start();

    if(!array_key_exists("nombre_usuario",$_SESSION))
    {
        header("Location: http://localhost/wahwah/views/login");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fundamentos2122.github.io/framework-css-gamadelgado60/css/framework.css">
    <title>Document</title>
    <style>
        .img-fluid
        {
            max-width: 100%;
            height: auto;
        }
        .card
        {
            border-radius: 0.5em;
        }
    </style>
</head>
<body >
    <div class="container-fluid container-lg">
        <?php include("banner.php"); ?>
        <br>
        <div class="col-md-4 col-12 but">
           <a href="nuevoproducto.php"><div class="btn btn-primary" >Vender ahora</div></a> 
        </div>
        <br>
        <div class="col lista-prod" >
        <div class="col-12 TitulProd bord-prod-t bord-prod-b">Favoritos</div>
            <?php
                include("../controllers/favoritosController.php");
            ?>
        </div>

        <br>
    </div>
    <?php include("foot.php");?>
</body>
</html>