<?php

namespace App\CorredoresRiojaBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CargaPaginasTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(
            array('/es/corredores/'),
            array('/es/corredores/carreras'),
            array('/es/corredores/carrera/2'),
            array('/es/corredores/login'),
            array('/es/corredores/registro'),
            array('/en/corredores/'),
            array('/en/corredores/races'),
            array('/en/corredores/login')
        );
    }
}


