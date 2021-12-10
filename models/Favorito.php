<?php

class Comentario {
    private $_id_F;
    private $_id_prod;
    private $_id_usuario;

    public function __construct($_id_F,$idprod,$idusuario){
        $this->setId($id_F);
        $this->setIdprod($id_producto);
        $this->setIdus($id_usuario);
    }

    public function getId(){
        return $this->_id_F;
    }
    public function setId($id_F){
        $this->_id_F = $id_F;
    }
    public function getIdprod(){
        return $this->_id_prod;
    }
    public function setIdprod($idprod){
        $this->_id_prod = $idprod;
    }
    public function getIdus(){
        return $this->_id_usuario;
    }
    public function setIdus($idusuario){
        $this->_id_usuario = $idusuario;
    }
}

?>