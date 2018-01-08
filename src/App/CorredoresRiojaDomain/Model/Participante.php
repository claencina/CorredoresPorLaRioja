<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Participante
 *
 * @author master
 */
namespace App\CorredoresRiojaDomain\Model;

use App\CorredoresRiojaDomain\Model\Carrera;
use App\CorredoresRiojaDomain\Model\Corredor;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\CorredoresRiojaInfrastructure\InBDRepository\ParticipanteRepository")
 * @ORM\Table(name = "participante")
 */
class Participante {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Corredor")
     * @ORM\JoinColumn(name="corredor_id", referencedColumnName="dni")
     */
    private $corredor;
    /**
     * @ORM\ManyToOne(targetEntity="Carrera")
     * @ORM\JoinColumn(name="carrera_id", referencedColumnName="id")
     */
    private $carrera;
    /**
     * @ORM\Column(type="integer")
     */
    private $dorsal;
    /**
     * @ORM\Column(type="float")
     */
    private $tiempo;
    
    function __construct($id,Corredor $corredor, Carrera $carrera) {
        $this->id = $id;
        $this->corredor = $corredor;
        $this->carrera = $carrera;
        $this->dorsal = rand();
        $this->tiempo = 0;
    }
    
    function getId() {
        return $this->id;
    }
    
    function getCorredor() {
        return $this->corredor;
    }

    function getCarrera() {
        return $this->carrera;
    }

    function getDorsal() {
        return $this->dorsal;
    }

    function getTiempo() {
        return $this->tiempo;
    }

    function asignarMarca($marca){
        $this->tiempo = $marca;
    }
    
    function __toString() {
        return "Tiempo participante: " . $this->tiempo;
    }            
}
