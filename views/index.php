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
        <div class="slider-frame">
            <a href="productos.php">
                <ul>
                    <li><img src="../imagenes/s1.jpg" alt=""></li>
                    <li><img src="../imagenes/s5.jpg" alt=""></li>
                    <li><img src="../imagenes/s1.jpg" alt=""></li>
                    <li><img src="../imagenes/s5.jpg" alt=""></li>
                </ul>
            </a>
        </div>
        <br>
        <br>
        <div class="col lista-prod" >
            <br>
            <div class="col-12 TitulProd bord-prod-t ">Categorias</div>
                <div class="row prod">
                    <div class="col-md-4 col-6"><img src="../imagenes/cat1.jpg" alt="" class="pimg"></div>
                    <div class="col-md-8 col-6 Tprod">
                        <a href="productos.php">Todos los instrumentos</a>
                    </div>
                </div>
                <br>
                <br>
                
                <br>
            </div>
    <br>
    </div>
    <?php include("foot.php");?>
</body>
</html>