<?php

namespace App\CorredoresRiojaInfrastructure\InBDRepository;

use App\CorredoresRiojaDomain\Repository\IOrganizacionRepository;
use App\CorredoresRiojaDomain\Model\Organizacion;
use Doctrine\ORM\EntityRepository;

class OrganizacionRepository extends EntityRepository implements IOrganizacionRepository{
    
    public function actualizar(Organizacion $organizacion){
        $em = $this->getEntityManager();
        $em->persist($organizacion);
        $em->flush(); 
    }

    public function buscarPorEmail($email){
        $em = $this->getEntityManager();
        return $em->getRepository(\Organizacion::class)->findOneBy($email);
    }

    public function buscarPorSlug($slug){
        $em = $this->getEntityManager();
        return $em->getRepository(\Organizacion::class)->findOneBy($slug);
    }

    public function eliminar(Organizacion $organizacion) {
        $em = $this->getEntityManager();
        $em->remove($organizacion);
        $em->flush();
    }

    public function listar(){
        $em = $this->getEntityManager();
        return $em->getRepository(\Organizacion::class)->findAll();
    }

    public function registrar(Organizacion $organizacion) {
        $em = $this->getEntityManager();
        $em->persist($organizacion);
        $em->flush();
    }

}
