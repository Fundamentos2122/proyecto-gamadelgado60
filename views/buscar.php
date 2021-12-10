<?php
    //verificar que el usuario este logueado
    session_start();
    if(!array_key_exists("nombre_usuario",$_SESSION))
    {
        header("Location: http://localhost/wahwah/views/login");
        exit();
    }
    $_SERVER["REQUEST_METHOD"]="POST";
    $_POST['id']=$_GET['id'];
    $_POST["_method"]="DELETE";
    $_POST["idus"]=$_SESSION["id"];
    include("../controllers/carritoController.php");
?>    