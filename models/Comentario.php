<?php

class Comentario {
    private $_id;
    private $_idprod;
    private $_nombre_usuario;
    private $_calificacion;
    private $_comentario;

    public function __construct($id,$idprod,$nombre_usuario,$calificacion,$comentario){
        $this->setId($id);
        $this->setIdprod($idprod);
        $this->setNombreUsuario($nombre_usuario);
        $this->setCalificacion($calificacion);
        $this->setComentario($comentario);
    }

    public function getId(){
        return $this->_id;
    }
    public function setId($id){
        $this->_id = $id;
    }
    public function getIdprod(){
        return $this->_idprod;
    }
    public function setIdprod($idprod){
        $this->_idprod = $idprod;
    }
    public function getNombreUsuario(){
        return $this->_nombre_usuario;
    }
    public function setNombreUsuario($nombre_usuario){
        $this->_nombre_usuario = $nombre_usuario;
    }
    public function getCalificacion(){
        return $this->_calificacion;
    }
    public function setCalificacion($calificacion){
        $this->_calificacion = $calificacion;
    }
    public function getComentario(){
        return $this->_comentario;
    }
    public function setComentario($comentario){
        $this->_comentario = $comentario;
    }
}

?>