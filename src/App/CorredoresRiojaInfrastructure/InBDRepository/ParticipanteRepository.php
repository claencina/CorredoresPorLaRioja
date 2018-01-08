<?php

namespace App\CorredoresRiojaInfrastructure\InBDRepository;

use App\CorredoresRiojaDomain\Repository\IParticipanteRepository;
use App\CorredoresRiojaDomain\Model\Corredor;
use App\CorredoresRiojaDomain\Model\Carrera;
use App\CorredoresRiojaDomain\Model\Participante;
use Doctrine\ORM\EntityRepository;

class ParticipanteRepository extends EntityRepository implements IParticipanteRepository{
       
    public function actualizarTiempoCorredor(Corredor $corredor, $tiempo){
         
    }

    public function corredorInscrito(Corredor $corredor, $idCarrera){
        $em = $this->getEntityManager();
        $repository = $em->getRepository(Participante::class);
        $q = $repository->createQueryBuilder('participante')
                ->join('participante.corredor', 'corredor')
                ->join('participante.carrera', 'carrera')
                ->where('corredor.dni = :dni')
                ->andwhere('carrera.id = :idCarrera')
                ->setParameter('dni', $corredor->getDni())
                ->setParameter('idCarrera', $idCarrera)
                ->getQuery();
        $corredorInscripto = $q->getResult();
        if($corredorInscripto == null){
            return false;
        }else{
            return true;
        }
    }

    public function eliminar($id) {
       $em = $this->getEntityManager();
       $participante = $em->getRepository(Participante::class)->findOneById($id);
       $em->remove($participante);
       $em->flush();
    }

    public function listarCarrerasDeUnCorredor(Corredor $corredor, $disputadas){        
        $em = $this->getEntityManager();
        $repository = $em->getRepository(Participante::class);
        if ($disputadas) {
            $q = $repository->createQueryBuilder('participante')
                    ->join('participante.corredor', 'corredor')
                    ->join('participante.carrera', 'carrera')
                    ->where('corredor.dni = :dni')
                    ->andwhere('carrera.fechaCelebracion < :fechaCelebracion')
                    ->setParameter('dni', $corredor->getDni())
                    ->setParameter('fechaCelebracion', (new \DateTime("now"))->format("Y-m-d"))
                    ->getQuery();
        } else {
            $q = $repository->createQueryBuilder('participante')
                    ->join('participante.corredor', 'corredor')
                    ->join('participante.carrera', 'carrera')
                    ->where('corredor.dni = :dni')
                    ->andwhere('carrera.fechaCelebracion >= :fechaCelebracion')
                    ->setParameter('dni', $corredor->getDni())
                    ->setParameter('fechaCelebracion', (new \DateTime("now"))->format("Y-m-d"))
                    ->getQuery();
        }
        return $q->getResult();
    }

    public function listarParticipacionesDeCorredores(Corredor $corredor){
        
    }

    public function listarParticipacionesDeUnaCarrera(Carrera $carrera){
        $em = $this->getEntityManager();
        $repository = $em->getRepository(Participante::class);
        $q = $repository->createQueryBuilder('participante')
                ->join('participante.carrera', 'carrera')
                ->where('carrera.id = :id_carrera')
                ->orderBy('participante.tiempo')
                ->setParameter('id_carrera', $carrera->getId())
                ->getQuery();        
        return $q->getResult();
    }

    public function registrar($idCarrera, Corredor $corredor) {
       $em = $this->getEntityManager();
       $carrera = $em->getRepository(Carrera::class)->findOneById($idCarrera);
       $participante = new Participante(null, $corredor, $carrera);
       $em->persist($participante);
       $em->flush();
    }

}
