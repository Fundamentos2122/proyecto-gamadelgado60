<?php
    //verificar que el usuario este logueado
    session_start();

    if(!array_key_exists("nombre_usuario",$_SESSION))
    {
        header("Location: http://localhost/wahwah/views/login");
        exit();
    }
    var_dump($_SESSION);
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
        <div class="col cont-prod">
            <form action="../controllers/productoController.php" method="post" class="row" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="POST">
                <div class="row contenP">
                    
                    <div class="col-12 bord-prod-t bord-prod-b TitulProd">Agregar producto</div>
                    <div class="col-12 col-md-6 form-group">
                        <br>
                        <p>imagenes del producto</p>
                        <input type="file" name="fotos" class="form-control">
                        
                    </div>
                    <div class="col-12 col-md-6 ">
                        <br>
                        <div class="col-12 bord-prod-t bord-prod-b form-group">
                            <br>
                            <label for="nombre">Nombre del producto</label>
                            <input type="text" name="nombre_prod" class="form-control">
                            <br>
                            <br>
                        </div>
                        <div class="col-12 bord-prod-b form-group">
                            <br>
                            <label for="nombre">Precio del producto</label>
                            <input type="text" name="precio_prod" class="form-control">
                            <br>
                            <br>
                        </div>
                        <br>
                    </div>
                    <div class="form-control">
                        <input type="hidden" name="id_vendedor" class="form-control" value=<?php echo $_SESSION['id'];?>/>
                    </div>
                    <div class="col-12 bord-prod-t form-group">
                        <br>
                        <label for="nombre">Descripcion</label>
                        <div class="col-12">
                            <textarea name="descripcion" id="" cols="30" rows="10"></textarea class="form-control">
                        </div>
                        
                        <br>
                        <br>
                    </div>
                    <div class="col-12 form-group" style="direction: rtl;">
                    <input type="submit" value="Guardar" class="btn btn-success">
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div> 
            </form>
            <br>
        </div>
        
    </div>
    </div>
    <?php include("foot.php");?>
</body>
</html>