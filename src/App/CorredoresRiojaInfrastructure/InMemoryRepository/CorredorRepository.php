<?php

namespace App\CorredoresRiojaInfrastructure\InMemoryRepository;

use App\CorredoresRiojaDomain\Repository\ICorredorRepository;
use App\CorredoresRiojaDomain\Model\Corredor;

class CorredorRepository implements ICorredorRepository{
    
    private $corredores;

    public function __construct() {
        $this->corredores[0] = new Corredor(1,"n","a","a@a.com","1234","dir", new \DateTime());
    }
    
    public function actualizar(Corredor $corredor){
        foreach ($this->corredores as $key => $value) {
            if ($value->getId() == $corredor -> getId()) {
                unset($this->corredores[$key]);
            }
        }
    }

    public function buscarPorDni($dni){
        foreach ($this->corredores as $value) {
            if ($value->getDni == $dni) {
                return $value;
            }
        }
        return null;
    }

    public function eliminar(Corredor $corredor) {
        foreach ($this->corredores as $key => $value) {
            if ($value->getId() == $corredor -> getId()) {
                $this->corredores = array_replace($this->corredores, $this->corredores[$key]);
            }
        }
    }

    public function listar(){
        return $this->corredores;
    }

    public function registrar(Corredor $corredor) {
        $this->corredores[1] =  $corredor;
    }

}
