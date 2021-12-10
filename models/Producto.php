<?php

class Producto {
    private $_id;
    private $_nombre_prod;
    private $_precio;
    private $_descripcion;
    private $_id_vendedor;
    private $_fotos;

    public function __construct($id,$nombre_prod,$precio_prod,$descripcion,$id_vendedor,$fotos){
        $this->setId($id);
        $this->setNombreProd($nombre_prod);
        $this->setPrecioProd($precio_prod);
        $this->setDescripcion($descripcion);
        $this->setIdVendedor($id_vendedor);
        $this->setFotos($fotos);
    }

    public function getId(){
        return $this->_id;
    }
    public function setId($id){
        $this->_id = $id;
    }
    public function getNombreProd(){
        return $this->_nombre_prod;
    }
    public function setNombreProd($nombre_prod){
        $this->_nombre_prod = $nombre_prod;
    }
    public function getPrecioProd(){
        return $this->_precio;
    }
    public function setPrecioProd($precio_prod){
        $this->_precio = $precio_prod;
    }
    public function getDescripcion(){
        return $this->_descripcion;
    }
    public function setDescripcion($descripcion){
        $this->_descripcion = $descripcion;
    }
    public function getIdvendedor(){
        return $this->_id_vendedor;
    }
    public function setIdvendedor($id_vendedor){
        $this->_id_vendedor = $id_vendedor;
    }
    public function getFotos(){
        return $this->_fotos;
    }
    public function setFotos($fotos){
        $this->_fotos = base64_encode($fotos);
    }
    public function returnJSon()
    {
        $producto = array();

        $producto["id"] = $this->getId();
        $producto["nombre_prod"] = $this->getNombreProd();
        $producto["precio"] = $this->getPrecioProd();
        $producto["descripcion"] = $this->getDescripcion();
        $producto["id_vendedor"] = $this->getIdvendedor();
        $producto["fotos"] = $this->getFotos();

        echo json_encode($producto);
    }

}

?>