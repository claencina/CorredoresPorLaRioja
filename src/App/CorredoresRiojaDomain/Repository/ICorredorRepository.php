<?php

namespace App\CorredoresRiojaDomain\Repository;

use App\CorredoresRiojaDomain\Model\Corredor;

interface ICorredorRepository {
    public function registrar(Corredor $corredor);
    public function actualizar(Corredor $corredor);
    public function eliminar(Corredor $corredor);
    public function buscarPorDni($dni);
    public function listar();
}
