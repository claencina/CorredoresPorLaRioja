<?php
namespace App\CorredoresRiojaBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\CorredoresRiojaDomain\Model\Organizacion;
use App\CorredoresRiojaDomain\Model\Carrera;

class CarreraRepositoryTest extends KernelTestCase{
    
    private $em;

    protected function setUp(){
        self::bootKernel();
        $this->em = self::$kernel->getContainer()->get('doctrine')->getManager();;
        //$this->repository = $this->container->get('carrerarepository');
    }
    

    public function testCarrerasEsCarrerasDisputadasYNoDisputadas(){        
        $carreras = $this->em->getRepository(Carrera::class)->listarTodas();
        $carrerasNoDisputadas = $this->em->getRepository(Carrera::class)->listar(false);
        $carrerasDisputadas = $this->em->getRepository(Carrera::class)->listar(true);
        
        foreach($carrerasDisputadas as $carrera){
            $this->assertContains($carrera,$carreras);
        }
        foreach($carrerasNoDisputadas as $carrera){
            $this->assertContains($carrera,$carreras);
        } 
    }
    
    public function testAnadirCarrera() {
        $org1 = new Organizacion("Ayuntamiento Matute", "El ayuntamiento de matute", "matute@gmail.com", "matute");
        $this->em->getRepository(Organizacion::class)->registrar($org1);
        $carrera = new Carrera(6, "Carrera Montes Anguiano", "Primera carrera por los montes de Anguiano", new \DateTime("2015-06-15"), 10, new \DateTime("2015-06-14"), 50, "anguiano.jpg", $org1);
        $this->em->getRepository(Carrera::class)->registrar($carrera);
        
        $this->assertNotNull($this->em->getRepository(Carrera::class)->buscarPorSlug('carrera-montes-anguiano'));
        
    }
    
    public function testCarrerasPorDisputar() {
        $carrerasNoDisputadas = $this->em->getRepository(Carrera::class)->listar(false);
        foreach ($carrerasNoDisputadas as $carrera) {
            $this->assertTrue($carrera->getFechacelebracion()->format("Y-m-d")> (new \DateTime('now'))->format("Y-m-d"));
        }
    }
    
    public function testEliminarCarrera() {
        $carrera = $this->em->getRepository(Carrera::class)->buscarPorSlug('carrera-montes-anguiano');
        $this->em->getRepository(Carrera::class)->eliminar($carrera);
        $this->assertNull($this->em->getRepository(Carrera::class)->buscarPorSlug('carrera-montes-anguiano'));
    }

    public function testCarrerasDisputadas() {
        $carrerasDisputadas = $this->em->getRepository(Carrera::class)->listar(TRUE);
        foreach ($carrerasDisputadas as $carrera) {
            $this->assertTrue($carrera->getFechacelebracion()->format("Y-m-d") < (new \DateTime('now'))->format("Y-m-d"));
        }
    }

}
