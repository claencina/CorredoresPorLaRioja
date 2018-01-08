<?php


namespace App\CorredoresRiojaBundle\Tests;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PortadaTest extends WebTestCase {

    // La portada muestra al menos una carrera activa
    public function testLaPortadaMuestraAlMenosUnaCarreraActiva() {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/es/corredores/');
        $carrerasActivas = $crawler->filter(
                        'html:contains("Inscribete")'
                )->count();
        $this->assertGreaterThan(0, $carrerasActivas, 'La portada muestra al menos una carrera para inscribirse'
        );
    }
    
    public function testCarreraBotonInscribirse(){
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', 'es/corredores/carrera/2');
        $carrerasActivas = $crawler->filter(
                        'html:contains("Inscribete")'
                )->count();
        $this->assertEquals(1, $carrerasActivas, 'Hay un boton para inscribirse'
        );
    }
}

