<?php

namespace App\CorredoresRiojaDomain\Model;

use App\Utils\Utils;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @ORM\Entity(repositoryClass="App\CorredoresRiojaInfrastructure\InBDRepository\OrganizacionRepository")
 * @ORM\Table(name = "organizacion")
 */
class Organizacion {    

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nombre;
    /**
     * @ORM\Column(type="string", length=200)
     */
    private $descripcion;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=200)
     */
    private $salt;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    function __construct( $nombre, $descripcion, $email, $password) {
        //$this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->email = $email;
        $this->password = $password;
        $this->salt = "";
        $this->slug = Utils::getSlug($nombre);
    }
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getSalt() {
        return $this->salt;
    }

    function getSlug() {
        return $this->slug;
    }

    function __toString() {
        return "Organizador: " . $this->nombre;
    }

}
