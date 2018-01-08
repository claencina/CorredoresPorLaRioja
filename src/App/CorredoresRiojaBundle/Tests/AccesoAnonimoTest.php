<?php


namespace App\CorredoresRiojaBundle\Tests;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccesoAnonimoTest extends WebTestCase{

    public function testLosUsuariosAnonimosDebenLoguearseParaPoderInscribirse() {
        // Creamos el cliente
        $client = static::createClient();
        // Hacemos una petición a la portada
        $crawler=$client->request('GET', '/es/corredores/');
        // Seleccionamos el enlace que contiene el texto Inscríbete
        $inscribete = $crawler->selectLink('Inscribete')->link();
        // El cliente hace click en el enlace 
        $client->click($inscribete);
        // Obtenemos la página a la cual se nos ha redirigido
        $crawler = $client->followRedirect();
        // Comprobamos que el formulario contenido en la nueva página tiene un
        // login_check
        $this->assertRegExp('/.*\/login_check/', $crawler->filter('form')->attr('action'), 'Después de pulsar el botón de inscribirse, el usuario anónimo ve el formulario de login');
    }
    
}

