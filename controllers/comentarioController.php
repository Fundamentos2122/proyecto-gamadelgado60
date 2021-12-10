<?php

include("../models/DB.php");
include("../models/Comentario.php");

try{
    $connection2 = DBConnection::getConnection();
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
        $idprod = $_GET["id"];
        $idusuario= $_GET["idus"];
        if($_GET["_method"]=="LEER")
        {
            try
        {
            $query = $connection2->prepare("SELECT * FROM comentarios WHERE idprod = :idprod");
            $query->bindParam(":idprod",$idprod,PDO::PARAM_INT);
            $query->execute();
            
            while($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $comentario = new comentario($row["idprod"],$row["idusuario"],$row["calificacion"],$row["comentario"]);
                
                echo
                "<div class='col-12 TitulProd bord-prod-t bord-prod-b'>Reseñas</div>".
            "<div class='row resena bord-prod-b'>".
                "<div class='col-md-4'>".
                    "<div class='TitulProd'>". $comentario.calificacion ."/5</div>".
                    "<p>". $comentario.idusuario ."</p>".
                "</div>".
                "<div class='col-md-8'>". $comentario.comentario ."</div>".
            "</div>";
            }     
        }
        catch(PDOException $e)
        {
            error_log("Error en query - " . $e,0);

            exit();
        }
        }else{
            //Traer la informacion de un elemento
        $id = $_GET["id"];
        try
        {
            $query = $connection2->prepare("SELECT * FROM producto WHERE id = :id");
            $query->bindParam(":id",$id,PDO::PARAM_INT);
            $query->execute();
            
            while($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $producto = new producto($row["id"],$row["nombre_prod"],$row["precio_prod"],$row["descripcion"],$row["id_vendedor"],$row["fotos"]);
                
                $alumno->returnJSon();
            }     

            exit();
        }
        catch(PDOException $e)
        {
            error_log("Error en query - " . $e,0);

            exit();
        }
        }
        
    }else{
        //traer el listado de todos los registros
        try
        {
            $query = $connection2->prepare("SELECT * FROM `producto`");
            $query->execute();

            while($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $producto = new producto($row["id"],$row["nombre_prod"],$row["precio_prod"],$row["descripcion"],$row["id_vendedor"],$row["fotos"]);
                
                echo
                "<br>".
                    "<div class='row prod'>".
                        "<div class='col-md-4 col-6'><img src=\"data:image/jpeg;base64,". $producto->getFotos() . "\" alt='' class='pimg'></div>".
                        "<div class='col-md-8 col-6'>".
                            "<div class='row'>".
                                "<div class='col-12 Tprod'><a href='productodetalles.php?id=" . $producto->getId() ."'>". $producto->getNombreProd()." </a></div>".
                                "<div class='col-12'><p>". 'envio gratis' ."</p></div>".
                                "<div class='col-8 Pprod'>". '$' . $producto->getPrecioProd() ."</div>".
                                "<div class='col-2'>" .'<img src="../imagenes/fav.svg" alt="" class="icon-md">'."</div>".
                                "<div class='col-6 col-2 '></div>".
                            "</div>".
                        "</div>".
                    "</div>".
                    "<br>".
                    "<br>";
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
        $nombre_prod = $_POST['nombre_prod'];
        $precio_prod = $_POST['precio_prod'];
        $descripcion = $_POST['descripcion'];
        $id_vendedor = $_POST['id_vendedor'];
        $fotos = "";
        
        if(sizeof($_FILES)>0)
        {
            $tmp_name = $_FILES["fotos"]["tmp_name"];
            $fotos = file_get_contents($tmp_name);
        }
        try{
            $query = $connection2->prepare('INSERT INTO producto VALUES(NULL, :nombre_prod, :precio_prod, :descripcion,:id_vendedor, :fotos)');
            $query->bindParam(':nombre_prod',$nombre_prod, PDO::PARAM_STR);
            $query->bindParam(':precio_prod', $precio_prod, PDO::PARAM_STR);
            $query->bindParam(':descripcion',$descripcion, PDO::PARAM_STR);
            $query->bindParam(':id_vendedor',$id_vendedor, PDO::PARAM_STR);
            $query->bindParam(':fotos',$fotos, PDO::PARAM_STR);
            $query->execute();

            if($query->rowCount()==0)
            {
                //Error
                exit();
            }

            header("Location: http://localhost/wahwah/views/");
        }
        catch(PDOException $e)
        {
            error_log("Error en query - " . $e,0);

            exit();
        }
    }else if($_POST["_method"]=="PUT")
    {   
        
        //Actualizar
        $id = $_GET["id"];
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
           
            $query = $connection2->prepare($query_string .' WHERE id = :id');
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
            $query = $connection2->prepare('DELETE FROM alumnos WHERE id = :id');
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