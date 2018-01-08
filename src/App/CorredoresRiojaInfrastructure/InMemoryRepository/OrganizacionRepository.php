<?php

class OrganizacionRepository implements IOrganizacionRepository{
    
     private $organizaciones;

    public function __construct() {
        $this->organizaciones = array();
    }
    
    public function actualizar(\Organizacion $organizacion){
        foreach ($this->organizaciones as $key => $value) {
            if ($value->getId() == $organizacion -> getId()) {
                unset($this->organizaciones[$key]);
            }
        }
    }

    public function buscarPorEmail(\String $email){
        foreach ($this->organizaciones as $value) {
            if ($value->getEmail == $email) {
                return $value;
            }
        }
    }

    public function buscarPorSlug(\String $slug){
        foreach ($this->organizaciones as $value) {
            if ($value->getSlug == $slug) {
                return $value;
            }
        }
    }

    public function eliminar(\Organizacion $organizacion) {
        foreach ($this->organizaciones as $key => $value) {
            if ($value->getId() == $organizacion -> getId()) {
                $this->organizaciones = array_replace($this->organizaciones, $this->organizaciones[$key]);
            }
        }
    }

    public function listar(){
        return $this->organizaciones;
    }

    public function registrar(\Organizacion $organizacion) {
        $this->organizaciones[] = $organizacion;
    }

}
