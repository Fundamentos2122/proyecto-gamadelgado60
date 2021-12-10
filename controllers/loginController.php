<?php

include("../models/DB.php");
include("../models/Usuario.php");

try{
    $connection = DBConnection::getConnection();
}
catch(PDOException $e)
{
    error_log("Error de conexcion - " . $e,0);

    exit();
}
if($_SERVER["REQUEST_METHOD"]=="GET")
{
    if(array_key_exists("id",$_GET))
    {
        $id = $_GET["idus"];
        if($_GET["_method"]=="LEER")
        {
            try
            {
                $query = $connection->prepare("SELECT * FROM usuario WHERE id = :id");
                $query->bindParam(":id",$id,PDO::PARAM_INT);
                $query->execute();
                while($row =$query->fetch(PDO::FETCH_ASSOC))
                {
                    $usuario = new Usuario($row["id"],$row["nombre_usuario"],$row["contrasena"],$row["email"],$row["tipo_rol"],);

                    echo
                    "<div class='TitulProd'>". $usuario->getNombreUsuario() ."</div>";
                }
                
            }
            catch(PDOException $e)
            {
                error_log("Error en query - " . $e,0);

                exit();
            }
        }
    }
}else if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if($_POST["_method"]=="SAVE")
    {
       
        $nombre_usuario = $_POST["nombre_usuario"];
        $contrasena =$_POST["contrasena"];
        $email =$_POST["email"];
        $tipo_rol =$_POST["tipo_rol"];
        try{
            $query = $connection->prepare('INSERT INTO usuarios VALUES(NULL, :nombre_usuario, :contrasena,:email,:tipo_rol)');
            $query->bindParam(':nombre_usuario',$nombre_usuario,PDO::PARAM_STR);
            $query->bindParam(':contrasena',$contrasena,PDO::PARAM_STR);
            $query->bindParam(':email',$email,PDO::PARAM_STR);
            $query->bindParam(':tipo_rol',$tipo_rol,PDO::PARAM_STR);
            $query->execute();
            

            if($query->rowCount()==0)
            {
                //Error

                exit();
            }

            header("Location: http://localhost/wahwah/views/login");
        }
        catch(PDOException $e)
        {
            error_log("Error en query - " . $e,0);

            exit();
        }
    }
    else if($_POST["_method"]=="POST")
    {
        //login
        $nombre_usuario = $_POST["nombre_usuario"];
        $contrasena =$_POST["contrasena"];
        try{
            $query = $connection->prepare('SELECT * FROM usuarios WHERE nombre_usuario = :nombre_usuario AND contrasena=:contrasena');
            $query->bindParam(':nombre_usuario',$nombre_usuario,PDO::PARAM_STR);
            $query->bindParam(':contrasena',$contrasena,PDO::PARAM_STR);
            $query->execute();

            if($query->rowCount() == 0)
            {
                //no se encontro al usuario
                header("Location: http://localhost/wahwah/views/login/index.php?error=Usuario o Contrasena invalida");

                exit();
            }
            $usuario;
            while($row =$query->fetch(PDO::FETCH_ASSOC))
            {
                $usuario = new Usuario($row["id"],$row["nombre_usuario"],$row["contrasena"],$row["email"],$row["tipo_rol"],);
            }
            session_destroy();
            session_start();
            $_SESSION["id"]= $usuario->getId();
            $_SESSION["nombre_usuario"]= $usuario->getNombreUsuario();
            $_SESSION["tipo_rol"]= $usuario->getTipoRol();

            header("Location: http://localhost/wahwah/views/");

        }
        catch(PDOException $e)
        {
            error_log("Error en query - " . $e,0);

            exit();
        }
    }else if($_POST["_method"]=="DELETE")
    {
        //logout
        session_start();
        session_destroy();

        header("Location: http://localhost/wahwah/views/login");
    }
}
?>