<?php

namespace App\CorredoresRiojaInfrastructure\InBDRepository;

use App\CorredoresRiojaDomain\Repository\ICorredorRepository;
use App\CorredoresRiojaDomain\Model\Corredor;
use Doctrine\ORM\EntityRepository;

class CorredorRepository extends EntityRepository implements ICorredorRepository{
    
    
    public function actualizar(Corredor $corredor){
        $em = $this->getEntityManager();
        $em->merge($corredor);
        $em->flush(); 
    }

    public function buscarPorDni($dni){
        $em = $this->getEntityManager();
        return $em->getRepository(Corredor::class)->findOneByDni($dni);
    }

    public function eliminar(Corredor $corredor) {
        $em = $this->getEntityManager();
        $em->remove($corredor);
        $em->flush();
    }

    public function listar(){
        $em = $this->getEntityManager();
        return $em->getRepository(Corredor::class)->findAll();
    }

    public function registrar(Corredor $corredor) {
        $em = $this->getEntityManager();
        $em->persist($corredor);
        $em->flush();
    }

}
