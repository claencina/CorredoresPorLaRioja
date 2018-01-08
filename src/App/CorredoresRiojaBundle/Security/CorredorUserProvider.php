<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\CorredoresRiojaBundle\Security;

use App\CorredoresRiojaBundle\Security\CorredorUser;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityManager;
use App\CorredoresRiojaDomain\Model\Corredor;
/**
 * Description of CorredorUserProvider
 *
 * @author USUARIO
 */
class CorredorUserProvider implements UserProviderInterface {

     private $em;

    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }

    public function loadUserByUsername($username) {
        // buscamos el usuario
        //$userData = $this->corredoresrepository->buscarPorDni($username);
        $userData = $this->em->getRepository(Corredor::class)->buscarPorDNI($username);
        // si existe el corredor, devolvemos un CorredorUser de 
        // lo contrario devolvemos una excepción
        if ($userData) {
            $password = $userData->getPassword();
            $salt = $userData->getSalt();
            return new CorredorUser($username, $password, $salt);
        }

        throw new UsernameNotFoundException(
        sprintf('No existe un usuario con DNI "%s".', $username)
        );
    }

    // La definición de estas dos funciones es casi siempre la misma
    public function refreshUser(UserInterface $user) {
        if (!$user instanceof CorredorUser) {
            throw new UnsupportedUserException(
            sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        return $class === 'App\CorredoresRiojaBundle\Security\CorredorUser';
    }

}
