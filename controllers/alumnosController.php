<?php

include("../models/DB.php");
include("../models/Alumno.php");

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
    //leer
    if(array_key_exists("id",$_GET))
    {
        //Traer la informacion de un elemento
        $id = $_GET["id"];
        try
        {
            $query = $connection->prepare("SELECT * FROM `alumnos` WHERE id = :id");
            $query->bindParam(":id",$id,PDO::PARAM_INT);
            $query->execute();
            while($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $alumno = new Alumno($row["id"], $row["cve_unica"], $row["nombre_completo"], $row["fecha_nacimiento"], $row["foto"]);
                
                $alumno->returnJSon();
            }     

            exit();
        }
        catch(PDOException $e)
        {
            error_log("Error en query - " . $e,0);

            exit();
        }
    }else{
        //traer el listado de todos los registros
        try
        {
            $query = $connection->prepare("SELECT * FROM `alumnos`");
            $query->execute();

            while($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $alumno = new Alumno($row["id"], $row["cve_unica"], $row["nombre_completo"], $row["fecha_nacimiento"], $row["foto"]);
                
                echo
                    "<div class='col-3'>".
                        "<a href='alumno_detalles.php?id=" . $alumno->getId() ."'>".
                            "<img src=\"data:image/jpeg;base64," . $alumno->getFoto() . "\"  class='img-fluid card'>".
                            "<p>" .$alumno->getNombreCompleto() ."</p>".
                        "</a>".
                    "</div>";
            }
        }
        catch(PDOException $e)
        {
            error_log("Error en query - " . $e,0);

            exit();
        }
    }
}
else if($_SERVER["REQUEST_METHOD"]== "POST")
{
    //var_dump($_POST);
    if($_POST["_method"]=="POST")
    {
        //guardar
        $cve_unica = $_POST["cve_unica"];
        $nombre_completo = $_POST['nombre_completo'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $foto = "";
        
        if(sizeof($_FILES)>0)
        {
            $tmp_name = $_FILES["foto"]["tmp_name"];
            $foto = file_get_contents($tmp_name);
        }
        try{
            $query = $connection->prepare('INSERT INTO alumnos VALUES(NULL, :cve_unica, :nombre_completo, :fecha_nacimiento, :foto)');
            $query->bindParam(':cve_unica',$cve_unica, PDO::PARAM_STR);
            $query->bindParam(':nombre_completo', $nombre_completo, PDO::PARAM_STR);
            $query->bindParam(':fecha_nacimiento',$fecha_nacimiento, PDO::PARAM_STR);
            $query->bindParam(':foto',$foto, PDO::PARAM_STR);
            $query->execute();

            if($query->rowCount()==0)
            {
                //Error

                exit();
            }

            header("Location: http://localhost/practicaphp-gamadelgado60/views/");
        }
        catch(PDOException $e)
        {
            error_log("Error en query - " . $e,0);

            exit();
        }
    }else if($_POST["_method"]=="PUT")
    {   
        
        //Actualizar
        $id = $_POST["id"];
        $cve_unica = $_POST["cve_unica"];
        $nombre_completo = $_POST['nombre_completo'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $foto = "";
        
        $update_foto = false;

        if(sizeof($_FILES)>0 && $_FILES["foto"]["tmp_name"]!== "")
        {
            $tmp_name = $_FILES["foto"]["tmp_name"];
            $foto = file_get_contents($tmp_name);
            $update_foto =true;
        }
        try{
          
            $query_string = 'UPDATE alumnos SET cve_unica = :cve_unica,nombre_completo = :nombre_completo,fecha_nacimiento= :fecha_nacimiento';
            if($update_foto == true)
            {
                $query_string = $query_string . ',foto = :foto';
            }
           
            $query = $connection->prepare($query_string .' WHERE id = :id');
            $query->bindParam(':id',$id, PDO::PARAM_INT);
            $query->bindParam(':cve_unica',$cve_unica, PDO::PARAM_STR);
            $query->bindParam(':nombre_completo', $nombre_completo, PDO::PARAM_STR);
            $query->bindParam(':fecha_nacimiento',$fecha_nacimiento, PDO::PARAM_STR);
            
            if($update_foto == true)
            {
                $query->bindParam(':foto',$foto, PDO::PARAM_STR);
            }

            $query->execute();

            if($query->rowCount ()==0)
            {
                //Error

                exit();
            }

            header("Location: http://localhost/practicaphp-gamadelgado60/views/");
        }
        catch(PDOException $e)
        {
            error_log("Error en query - " . $e,0);
            
            exit();
        }
    }else if($_POST["_method"]=="DELETE")
    {
        //Eliminar
        $id = $_GET["id"];
        try{
            $query = $connection->prepare('DELETE FROM alumnos WHERE id = :id');
            $query->bindParam(':id',$id, PDO::PARAM_INT);
            $query->execute();

            if($query->rowCount ()==0)
            {
                //Error

                exit();
            }
            header("Location: http://localhost/practicaphp-gamadelgado60/views/");
        }
        catch(PDOException $e)
        {
            error_log("Error en query - " . $e,0);

            exit();
        }

    }else{
        //error
    }
}

?>