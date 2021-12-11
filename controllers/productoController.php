<?php

include("../models/DB.php");
include("../models/Producto.php");
include("../models/Comentario.php");

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
                $producto = new producto($row["id"],$row["nombre_prod"],$row["precio_prod"],$row["descripcion"],$row["id_vendedor"],$row["fotos"]);
                if($idus==$producto->getIdvendedor())
                {
                    echo
                    "<a href='editarPord.php?id=" . $producto->getId() ."'><div class='btn btn-primary'>Editar producto</div></a>";
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
                            "<a href='agregafavprod.php?id=" . $producto->getId() ."'><div class='btn btn-primary'>Agregar a favoritos</div></a>".
                        "</div>".
                        "<div class='col-md-4 col-12 but'>".
                            "<a href='agregarcarprod.php?id=" . $producto->getId() ."'><div class='btn btn-primary'>Agregar al carrito</div></a>".
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
                $comentario = new comentario($row["id"],$row["idprod"],$row["nombre_usuario"],$row["calificacion"],$row["comentario"]);
                
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
    }
        else{
            //Traer la informacion de un elemento
        $id = $_GET["id"];
        try
        {
            $query = $connection->prepare("SELECT * FROM producto WHERE id = :id");
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
            $query = $connection->prepare("SELECT * FROM `producto`");
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
                                "<div class='col-2'><a href='agregafavprod.php?id=" . $producto->getId() ."'><img src='../imagenes/fav.svg' alt='' class='icon-md'></a></div>".
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
            $query = $connection->prepare('INSERT INTO producto VALUES(NULL, :nombre_prod, :precio_prod, :descripcion,:id_vendedor, :fotos)');
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
        var_dump($_POST);
        //Actualizar
        $id = $_POST["id"];
        $nombre_prod = $_POST['nombre_prod'];
        $precio_prod = $_POST['precio_prod'];
        $descripcion = $_POST['descripcion'];
        $id_vendedor = $_POST['id_vendedor'];
        $fotos = "";
        
        var_dump($_FILES);
        $update_foto = false;

        if(sizeof($_FILES)>0 && $_FILES["fotos"]["tmp_name"]!== "")
        {
            $tmp_name = $_FILES["fotos"]["tmp_name"];
            $fotos = file_get_contents($tmp_name);
            $update_foto =true;
        }
        try{
            //UPDATE producto SET nombre_prod='vox2', precio_prod=500, descripcion='hola',id_vendedor=1 WHERE id = 8
            $query_string = 'UPDATE producto SET nombre_prod=:nombre_prod, precio_prod=:precio_prod, descripcion=:descripcion,id_vendedor=:id_vendedor';
            if($update_foto == true)
            {
                $query_string = $query_string . ',fotos = :fotos';
            }
           
            $query = $connection->prepare($query_string .' WHERE id = :id');
            $query->bindParam(':id',$id, PDO::PARAM_INT);
            $query->bindParam(':nombre_prod',$nombre_prod, PDO::PARAM_STR);
            $query->bindParam(':precio_prod', $precio_prod, PDO::PARAM_STR);
            $query->bindParam(':descripcion',$descripcion, PDO::PARAM_STR);
            $query->bindParam(':id_vendedor',$id_vendedor, PDO::PARAM_STR);
            
            if($update_foto == true)
            {
                $query->bindParam(':fotos',$fotos, PDO::PARAM_STR);
            }

            $query->execute();

            if($query->rowCount ()==0)
            {
                //Error

                exit();
            }

            header("Location: http://localhost/wahwah/views/productos.php");
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

    }else if($_POST["_method"]=="NCOM")
    {
        //ar_dump($_POST);
        //guardar comentario
        $idprod = $_POST['idprod'];
        $nombre_usuario = $_POST['nombre_usuario'];
        $calificacion = $_POST['calificacion'];
        $comentario = $_POST['comentario'];
        try{
            $query = $connection->prepare('INSERT INTO comentarios VALUES(NULL,:idprod, :nombre_usuario, :calificacion,:comentario)');
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
    if($_POST["_method"]=="BUS")
    {
        try
    {
        
        $busqueda=$_POST["busqueda"];
       
        $query = $connection->prepare("SELECT * FROM producto WHERE nombre_prod = :busqueda");
        $query->bindParam(":busqueda",$busqueda,PDO::PARAM_INT);
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
                                "<div class='col-2'><a href='agregafavprod.php?id=" . $producto->getId() ."'><img src='../imagenes/fav.svg' alt='' class='icon-md'></a></div>".
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
    else{
        //error
    }
}

?>