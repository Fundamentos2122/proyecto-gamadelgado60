<?php

class Alumno {
    private $_id;
    private $_cve_unica;
    private $_nombre_completo;
    private $_fecha_nacimiento;
    private $_foto;

    public function __construct($id,$cve_unica,$nombre_completo,$fecha_nacimiento,$foto){
        $this->setId($id);
        $this->setCveUnica($cve_unica);
        $this->setNombreCompleto($nombre_completo);
        $this->setFechaNacimiento($fecha_nacimiento);
        $this->setFoto($foto);
    }

    public function getId(){
        return $this->_id;
    }
    public function setId($id){
        $this->_id = $id;
    }
    public function getCveUnica(){
        return $this->_cve_unica;
    }
    public function setCveUnica($cve_unica){
        $this->_cve_unica = $cve_unica;
    }
    public function getNombreCompleto(){
        return $this->_nombre_completo;
    }
    public function setNombreCompleto($nombre_completo){
        $this->_nombre_completo = $nombre_completo;
    }
    public function getFechaNacimiento(){
        return $this->_fecha_nacimiento;
    }
    public function setFechaNacimiento($fecha_nacimiento){
        $this->_fecha_nacimiento = $fecha_nacimiento;
    }
    public function getFoto(){
        return $this->_foto;
    }
    public function setFoto($foto){
        $this->_foto = base64_encode($foto);
    }

    public function returnJSon()
    {
        $alumno = array();

        $alumno["id"] = $this->getId();
        $alumno["cve_unica"] = $this->getCveUnica();
        $alumno["nombre_completo"] = $this->getNombreCompleto();
        $alumno["fecha_nacimiento"] = $this->getFechaNacimiento();
        $alumno["foto"] = $this->getFoto();

        echo json_encode($alumno);
    }
}

?>