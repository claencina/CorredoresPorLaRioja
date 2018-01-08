<?php
namespace App\CorredoresRiojaDomain\Model;


use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\CorredoresRiojaInfrastructure\InBDRepository\CorredorRepository")
 * @ORM\Table(name = "corredor")
 */
class Corredor {
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=9)
     */
    private $dni;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nombre;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $apellidos;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=200)
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $salt;
    /**
     * @ORM\Column(type="string", length=200)
     */
    private $direccion;
    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaNacimiento;
    
    function __construct($dni, $nombre, $apellidos, $email, $password, $direccion, $fechaNacimiento) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->password = $password;
        $this->direccion = $direccion;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->salt = "";
        
    }
    
    function getDni() {
        return $this->dni;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
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

    function getDireccion() {
        return $this->direccion;
    }

    function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    function __toString() {
        return "Corredor: " . $this->nombre . " " . $this->apellidos;
    }
    
    /**
     * @Assert\IsTrue(message = "La contraseña no puede ser la misma que tu nombre")
     */
    public function isPasswordLegal() {
        return $this-> nombre != $this->password;
    }
    
    /**
     * @Assert\IsTrue(message = "Tienes que ser mayor de edad para registrarte")
     */
    public function isMayorEdad(){
        $currentyear = getdate()['year'];
        $birthdayyear = ($this->fechaNacimiento->format('Y'));
        $diff_years = ($currentyear - $birthdayyear);
        return $diff_years >=18;
    }
    
    public function saveEncodedPassword($password){
        $this->password = $password;
    }
            
}
