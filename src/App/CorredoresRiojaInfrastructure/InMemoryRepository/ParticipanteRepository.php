<?php

class ParticipanteRepository implements IParticipanteRepository{
    
    private $participantes;

    public function __construct() {
        $this->participantes = array();
    }
    
    public function actualizarTiempoCorredor(\Corredor $corredor, \DateTime $tiempo){
         foreach ($this->participantes as $key => $value) {
            if ($value->getCorredor()->getId() == $corredor -> getId()) {
                $value->asignarMarca($tiempo);
                unset($this->participantes[$key]);
            }
        }
    }

    public function comprobarCorredorInscrito(\Corredor $corredor){
        
    }

    public function eliminar(\Corredor $corredor) {
        
    }

    public function listarCarrerasDeUnCorredor(\Corredor $corredor, bool $disputada){
        
    }

    public function listarParticipacionesDeCorredores(\Corredor $corredor){
        
    }

    public function listarParticipacionesDeUnaCarrera(\Carrera $carrera){
        
    }

    public function registrar(\Participante $participante) {
        
    }

}
