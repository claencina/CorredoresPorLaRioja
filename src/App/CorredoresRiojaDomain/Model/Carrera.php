<?php

namespace App\CorredoresRiojaDomain\Model;
use Doctrine\ORM\Mapping as ORM;
use App\CorredoresRiojaDomain\Model\Organizacion;
use App\Utils\Utils;

/**
 * @ORM\Entity(repositoryClass="App\CorredoresRiojaInfrastructure\InBDRepository\CarreraRepository")
 * @ORM\Table(name = "carrera")
 */
class Carrera {

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
     * @ORM\Column(name="fecha_celebracion", type="datetime")
     */
    private $fechaCelebracion;
    /**
     * @ORM\Column(type="integer")
     */
    private $distancia;
    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaLimiteInscripcion;
    /**
     * @ORM\Column(type="integer")
     */
    private $numeroMaximoParticipantes;
    /**
     * @ORM\Column(type="string", length=200)
     */
    private $imagen;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $slug;
    /**
     * @ORM\ManyToOne(targetEntity="Organizacion")
     * @ORM\JoinColumn(name="organizacion_id", referencedColumnName="id")
     */
    private $organizacion;
    
    private $inscribirse;

    function __construct($id, $nombre, $descripcion, $fechaCelebracion, $distancia, $fechaLimiteInscripcion, $numeroMaximoParticipantes, $imagen, Organizacion $organizacion) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->fechaCelebracion = $fechaCelebracion;
        $this->distancia = $distancia;
        $this->fechaLimiteInscripcion = $fechaLimiteInscripcion;
        $this->numeroMaximoParticipantes = $numeroMaximoParticipantes;
        $this->imagen = $imagen;
        $this->slug = Utils::getSlug($nombre);
        $this->organizacion = $organizacion;
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

    function getFechaCelebracion() {
        return $this->fechaCelebracion;
    }

    function getDistancia() {
        return $this->distancia;
    }

    function getFechaLimiteInscripcion() {
        return $this->fechaLimiteInscripcion;
    }

    function getNumeroMaximoParticipantes() {
        return $this->numeroMaximoParticipantes;
    }

    function getImagen() {
        return $this->imagen;
    }

    function getSlug() {
        return $this->slug;
    }
    
    function getOrganizacion() {
        return $this->organizacion;
    }
    function getInscribirse() {
        return $this->inscribirse;
    }

    function setInscribirse($inscribirse) {
        $this->inscribirse = $inscribirse;
    }

    function __toString() {
        return "Carrera: " . $this->nombre;
    }

}
