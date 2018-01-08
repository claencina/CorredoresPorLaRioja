<?php

namespace App\CorredoresRiojaDomain\Repository;

use App\CorredoresRiojaDomain\Model\Carrera;

interface ICarreraRepository {
    public function registrar(Carrera $carrera);
    public function actualizar(Carrera $carrera);
    public function eliminar(Carrera $carrera);
    public function buscarPorSlug($slug);
    public function listarPorOrganizacionCarreras($idOrganizacion, $disputadas);
    public function listarTodas();
    public function listar($disputadas);
    
}
