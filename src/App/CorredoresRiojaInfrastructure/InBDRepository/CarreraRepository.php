<?php

namespace App\CorredoresRiojaInfrastructure\InBDRepository;

use Doctrine\ORM\EntityRepository;
use App\CorredoresRiojaDomain\Model\Carrera;
use App\CorredoresRiojaDomain\Repository\ICarreraRepository;

class CarreraRepository extends EntityRepository implements ICarreraRepository {


    public function actualizar(Carrera $carrera){
        $em = $this->getEntityManager();
        $em->persist($carrera);
        $em->flush();       
    }

    public function buscarPorSlug($slug){
        $em = $this->getEntityManager();
        return $em->getRepository(Carrera::class)->findOneBySlug($slug);
    }

    public function eliminar(Carrera $carrera) {
       $em = $this->getEntityManager();
       $em->remove($carrera);
       $em->flush();
    }

    public function listar($disputadas){
       $em = $this->getEntityManager();
        $repository = $em->getRepository(Carrera::class);
        if ($disputadas) {
            $q = $repository->createQueryBuilder('carrera')
                    ->where('carrera.fechaCelebracion < :fechaCelebracion')
                    ->setParameter('fechaCelebracion', (new \DateTime("now"))->format("Y-m-d"))
                    ->getQuery();
        } else {
            $q = $repository->createQueryBuilder('carrera')
                    ->where('carrera.fechaCelebracion >= :fechaCelebracion')
                    ->setParameter('fechaCelebracion', (new \DateTime("now"))->format("Y-m-d"))
                    ->getQuery();
        }
        return $q->getResult();
    }

    public function listarPorOrganizacionCarreras($idOrganizacion, $disputadas){
        $em = $this->getEntityManager();
        $repository = $em->getRepository(Carrera::class);
        if ($disputadas) {
            $q = $repository->createQueryBuilder('carrera')
                    ->innerJoin('carrera.organizacion', 'organizacion')
                    ->where('carrera.fechaCelebracion < :fechaCelebracion')
                    ->andWhere('organizacion.id = :organizacion')
                    ->setParameter('fechaCelebracion', (new \DateTime("now"))->format("Y-m-d"))
                    ->setParameter('organizacion', $idOrganizacion)
                    ->getQuery();
        } else {
            $q = $repository->createQueryBuilder('carrera')
                    ->innerJoin('carrera.organizacion', 'organizacion')
                    ->where('carrera.fechaCelebracion >= :fechaCelebracion')
                    ->andWhere('organizacion.id = :organizacion')
                    ->setParameter('fechaCelebracion', (new \DateTime("now"))->format("Y-m-d"))
                    ->setParameter('organizacion', $idOrganizacion)
                    ->getQuery();
        }
        return $q->getResult();
    }

    public function listarTodas(){
       $em = $this->getEntityManager();
       return $em->getRepository(Carrera::class)->findAll();
    }

    public function registrar(Carrera $carrera) {
       $em = $this->getEntityManager();
       $em->persist($carrera);
       $em->flush();
    }

}
