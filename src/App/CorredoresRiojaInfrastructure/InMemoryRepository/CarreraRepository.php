<?php

class CarreraRepository implements ICarreraRepository {

    private $carreras;

    public function __construct() {
        $this->carreras = array();
    }

    public function actualizar(\Carrera $carrera){
        foreach ($this->carreras as $key => $value) {
            if ($value->getId() == $carrera -> getId()) {
                unset($this->carreras[$key]);
            }
        }
    }

    public function buscarPorSlug(\String $slug){
        foreach ($this->carreras as $value) {
            if ($value->getSlug == $slug) {
                return $value;
            }
        }
        return null;
    }

    public function eliminar(\Carrera $carrera) {
        foreach ($this->carreras as $key => $value) {
            if ($value->getId() == $carrera -> getId()) {
                $this->carreras = array_replace($this->carreras, $this->carreras[$key]);
            }
        }
    }

    public function listar(bool $disputadas){
        $carrerasResultado = array();
        $fecha = new DateTime();
        foreach ($this->carreras as $value) {
            if ($disputadas) {
                if ($value->getFechaCelebracion->format('Y-m-d') < $fecha->format('Y-m-d')) {
                    $carrerasResultado[] = $value;
                }
            } else {
                if ($value->getFechaCelebracion->format('Y-m-d') >= $fecha->format('Y-m-d')) {
                    $carrerasResultado[] = $value;
                }
            }
        }
        return $carrerasResultado;
    }

    public function listarPorOrganizacionCarreras(int $idOrganizacion, bool $disputadas){
        
    }

    public function listarTodas(){
        return $this->carreras;
    }

    public function registrar(\Carrera $carrera) {
        $this->carreras[] = $carrera;
    }

}
