<?php

namespace App\CorredoresRiojaDomain\Repository;

use App\CorredoresRiojaDomain\Model\Carrera;
use App\CorredoresRiojaDomain\Model\Corredor;
use App\CorredoresRiojaDomain\Model\Participante;

interface IParticipanteRepository {
    public function registrar($idCarrera, Corredor $corredor);
    public function listarParticipacionesDeCorredores(Corredor $corredor);
    public function listarParticipacionesDeUnaCarrera(Carrera $carrera);
    public function listarCarrerasDeUnCorredor(Corredor $corredor, $disputada);
    public function corredorInscrito(Corredor $corredor, $idCarrera);
    public function actualizarTiempoCorredor(Corredor $corredor, $tiempo);
    public function eliminar($id);
   
}
