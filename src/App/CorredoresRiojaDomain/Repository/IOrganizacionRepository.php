<?php

namespace App\CorredoresRiojaDomain\Repository;

use App\CorredoresRiojaDomain\Model\Organizacion;

interface IOrganizacionRepository {
    public function registrar(Organizacion $organizacion);
    public function actualizar(Organizacion $organizacion);
    public function eliminar(Organizacion $organizacion);
    public function buscarPorSlug($slug);
    public function buscarPorEmail($email);
    public function listar();
}
