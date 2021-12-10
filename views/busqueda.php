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
        <br>
        <div class="col lista-prod" >
        <div class="col-12 TitulProd bord-prod-t bord-prod-b">Resultado de la busqueda</div>
            <?php
                $_SERVER["REQUEST_METHOD"]="POST";
                $_POST['busqueda']=$_POST['busqueda'];
                $_POST["_method"]="BUS";
                include("../controllers/productoController.php");
            ?>
        </div>

        <br>
    </div>
    <?php include("foot.php");?>
</body>
</html>