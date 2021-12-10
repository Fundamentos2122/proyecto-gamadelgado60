<?php
    //verificar que el usuario este logueado
    session_start();

    if(array_key_exists("nombre_usuario",$_SESSION))
    {
        header("Location: http://localhost/practicaphp-gamadelgado60/views/");
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
        <?php include("../bannerl.php");?>
    <br>
    <div class="col" style="height: auto;">
                <div class="form">
                  <form class="login-form" action="../../controllers/loginController.php" method="POST" autocomplete="off">
                  <input type="hidden" name="_method" value="POST">
                  <?php
                    if(array_key_exists("error",$_GET))
                    {
                        echo $_GET["error"];
                    }
                  ?>
                    <div class="form-group">
                    <img src="../../imagenes/logo.png" alt="" class="img-log">
                    <input type="text" name="nombre_usuario" class="form-control" placeholder="Nombre de usuario"/>
                    </div>
                    <div class="form-group">
                    <input type="password" name="contrasena" class="form-control" placeholder="Contraseña"/>
                    </div>
                    <div class="form-group">
                    <input type="submit"value="iniciar sesion" class="btn btn-primary" >
                    </div>
                    <p class="message">No registrado <a href="registrar.php">Registrate</a></p>
                  </form>
                </div>
        </div>
    </div>
    <?php include("../foot.php");?>
        
</body>
</html>