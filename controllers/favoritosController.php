<?php

include("../models/DB.php");
include("../models/Producto.php");
include("../models/favorito.php");

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
        $id = $_GET["id"];
        $idus= $_GET["idus"];
        $idprod = $_GET["id"];
        if($_GET["_method"]=="LEER")
        {
            try
        {
            $query = $connection->prepare("SELECT * FROM producto WHERE id = :id");
            $query->bindParam(":id",$id,PDO::PARAM_INT);
            $query->execute();
            
            while($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $producto = new producto($row["id"],$row["nombre_prod"],$row["id_usuario"],$row["descripcion"],$row["id_vendedor"],$row["fotos"]);
                if($idus==$producto->getIdvendedor())
                {
                    echo
                    "<a href='agrecarrprod.php?id=" . $producto->getId() ."'><div class='btn btn-primary'>Editar producto</div></a>";
                }
                echo
                "<div class='col cont-prod'>".
                "<div class='row contenP'>".
                "<div class='col-12 col-md-6'>".
                    "<div class='col-md-4 col-6'><img src=\"data:image/jpeg;base64,". $producto->getFotos() . "\" alt='' class='pimg'></div>".
                "</div>".
                "<div class='col-12 col-md-6'>".
                    "<br>".
                    "<div class='col-12 TitulProd bord-prod-t bord-prod-b'>". $producto->getNombreProd()." </div>".
                    "<div class='Pprod bord-prod-b'>". '$' . $producto->getPrecioProd() ."</div>".
                    "<br>".
                    "<div class='row btns-prod'>".
                        "<div class='col-md-4 col-12 but'>".
                            "<a href='comprarprod.php?id=" . $producto->getId() ."'><div class='btn btn-primary'>Comprar ahora</div></a>".
                        "</div>".
                        "<div class='col-md-4 col-12 but'>".
                            "<a href='agrefavprod.php?id=" . $producto->getId() ."'><div class='btn btn-primary'>Agregar a favoritos</div></a>".
                        "</div>".
                        "<div class='col-md-4 col-12 but'>".
                            "<a href='agrecarrprod.php?id=" . $producto->getId() ."'><div class='btn btn-primary'>Agregar al carrito</div></a>".
                        "</div>".
                    "</div>".
                "</div>".
            "</div>".
            "<br>".
        "</div>".
        "<br>".
        "<div class='col cont-prod'>".
            "<div class='row'>".
                "<div class='col-12 TitulProd bord-prod-t bord-prod-b'>Descripcion</div>".
                "<div class='col-12'>"
                . $producto->getDescripcion() .
                "</div>".
            "</div>".
        "</div>";
            }  
            echo
            "<br>".
            "<div class='col cont-prod'>".
            "<div class='col-12 TitulProd bord-prod-t bord-prod-b'>Reseñas</div>";
            $query = $connection->prepare("SELECT * FROM comentarios WHERE idprod = :idprod");
            $query->bindParam(":idprod",$idprod,PDO::PARAM_INT);
            $query->execute();
            
            while($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $comentario = new comentario($row["idprod"],$row["nombre_usuario"],$row["calificacion"],$row["comentario"]);
                
                echo
            "<div class='row resena bord-prod-b'>".
                "<div class='col-md-4'>".
                    "<div class='TitulProd'>". $comentario->getCalificacion() ."/5</div>".
                    "<p>". $comentario->getNombreUsuario() ."</p>".
                "</div>".
                "<div class='col-md-8'>". $comentario->getComentario() ."</div>".
            "</div>".
            "<br>";
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
            $query = $connection->prepare("SELECT * FROM producto WHERE id = :id");
            $query->bindParam(":id",$id,PDO::PARAM_INT);
            $query->execute();
            
            while($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $producto = new producto($row["id"],$row["nombre_prod"],$row["id_usuario"],$row["descripcion"],$row["id_vendedor"],$row["fotos"]);
                
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
            $idus = $_SESSION["id"];
            $query = $connection->prepare("SELECT * FROM favoritos,producto WHERE id_usuario = $idus AND id_Producto = id");
            $query->execute();

            while($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $producto = new producto($row["id"],$row["nombre_prod"],$row["id_usuario"],$row["descripcion"],$row["id_vendedor"],$row["fotos"]);
                
                echo
                "<br>".
                    "<div class='row prod'>".
                        "<div class='col-md-4 col-6'><img src=\"data:image/jpeg;base64,". $producto->getFotos() . "\" alt='' class='pimg'></div>".
                        "<div class='col-md-8 col-6'>".
                            "<div class='row'>".
                                "<div class='col-12 Tprod'><a href='productodetalles.php?id=" . $producto->getId() ."'>". $producto->getNombreProd()." </a></div>".
                                "<div class='col-12'><p>". 'envio gratis' ."</p></div>".
                                "<div class='col-8 Pprod'>". '$' . $producto->getPrecioProd() ."</div>".
                                "<div class='col-2'><a href='eliminafavprod.php?id=" . $producto->getId() ."'><img src='../imagenes/basu.svg' alt='' class='icon-md'></a></div>".
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
    if($_POST["_method"]=="POST")
    {
        //guardar
        //var_dump($_POST);
        $id_producto = $_POST['id'];
        $id_usuario = $_POST['idus'];
        
        try{
            $query = $connection->prepare('INSERT IGNORE INTO favoritos VALUES(NULL,:id_producto, :id_usuario)');
            $query->bindParam(':id_producto',$id_producto, PDO::PARAM_INT);
            $query->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $query->execute();

            if($query->rowCount()==0)
            {
                //Error
                exit();
            }

            header("Location: http://localhost/wahwah/views/favoritos.php");
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
        //var_dump($_GET);
        $id_producto = $_GET["id"];
        $id_usuario = $_POST["idus"];
        try{
            $query = $connection->prepare('DELETE FROM favoritos WHERE id_producto= :id_producto AND id_usuario = :id_usuario');
            $query->bindParam(':id_producto',$id_producto, PDO::PARAM_INT);
            $query->bindParam(':id_usuario',$id_usuario, PDO::PARAM_INT);
            $query->execute();
            if($query->rowCount ()==0)
            {
                //Error

                exit();
            }
            header("Location: http://localhost/wahwah/views/favoritos.php");
        }
        catch(PDOException $e)
        {
            error_log("Error en query - " . $e,0);

            exit();
        }

    }else if($_POST["_method"]=="NCOM")
    {
        //ar_dump($_POST);
        //guardar comentario
        $idprod = $_POST['idprod'];
        $nombre_usuario = $_POST['nombre_usuario'];
        $calificacion = $_POST['calificacion'];
        $comentario = $_POST['comentario'];
        try{
            $query = $connection->prepare('INSERT INTO comentarios VALUES(:idprod, :nombre_usuario, :calificacion,:comentario)');
            $query->bindParam(':idprod',$idprod, PDO::PARAM_INT);
            $query->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
            $query->bindParam(':calificacion',$calificacion, PDO::PARAM_INT);
            $query->bindParam(':comentario',$comentario, PDO::PARAM_STR);
            $query->execute();

            if($query->rowCount()==0)
            {
                //Error
                exit();
            }

            header("Location: http://localhost/wahwah/views/productodetalles.php?id=".$idprod);
        }
        catch(PDOException $e)
        {
            error_log("Error en query - " . $e,0);

            exit();
        }
    }
    else{
        //error
    }
}

?>