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
    <script>
    window.onload=function(){
                // Una vez cargada la página, el formulario se enviara automáticamente.
		//document.forms["miformulario"].submit();
    }
    </script>
</head>
<body >
    <div class="container-fluid container-lg">
        <?php include("banner.php"); ?>
        <br>
        
        <?php
            $_SERVER["REQUEST_METHOD"]="GET";
            $_GET["_method"]="LEER";
            $_GET["idus"]=$_SESSION["id"];
            include("../controllers/productoController.php");
        ?>
        <form action="../controllers/productoController.php" method="post" class="row" autocomplete="off" enctype="multipart/form-data" class="row resena bord-prod-b">
        <input type="hidden" name="_method" value="NCOM">
        <input type="hidden" name="idprod" value=<?php echo $_GET['id'];?>>
        <input type="hidden" name="nombre_usuario" value=<?php echo $_SESSION['nombre_usuario'];?>>
            <div class="col-12 ">
                    <div class="TitulProd">Escribir una resena</div>
                </div>
                <div class="col-12 col-md-2 form-group">
                    <p>Calificacion</p>
                    <select name="calificacion" id="calificacion" class="form-control">
                        <option value="5">5</option>
                        <option value="4">4</option>
                        <option value="3">3</option>
                        <option value="2">2</option>
                        <option value="1">1</option>
                    </select>
                </div>
                <div class="col-10 form-group">
                    <textarea name="comentario" id="comentario" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="col-12 form-group" style="direction: rtl;">
                <input type="submit" value="Guardar" class="btn btn-primary">
                </div>
        </form>
        <br>
</div>
    </div>
    <?php include("foot.php");?>
</body>
</html>