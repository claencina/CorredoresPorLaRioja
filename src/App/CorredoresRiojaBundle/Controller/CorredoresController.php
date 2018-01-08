<?php

namespace App\CorredoresRiojaBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\CorredoresRiojaBundle\Form\CorredorType;
use Doctrine\ORM\EntityManager;
use App\CorredoresRiojaDomain\Model\Corredor;
use App\CorredoresRiojaDomain\Model\Carrera;
use App\CorredoresRiojaDomain\Model\Participante;
use Twig_Environment;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use BeSimple\I18nRoutingBundle\Routing\Router;

class CorredoresController extends Controller{
    
    private $twig;
    private $em;
    private $authenticationUtils;
    private $formFactory;
    private $encoderFactory;
    private $tokenStorage;
    private $router;

    public function __construct(Twig_Environment $twig, EntityManager $entityManager, AuthenticationUtils $authenticationUtils, FormFactory $formFactory, EncoderFactory $encoderFactory, TokenStorage $tokenStorage, Router $router) {
        $this->twig = $twig;
        $this->em = $entityManager;
        $this->authenticationUtils = $authenticationUtils;
        $this->formFactory = $formFactory;
        $this->encoderFactory = $encoderFactory;
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }
   
    public function listaCarrerasAction() {
        $carreras = $this->em->getRepository(Carrera::class)->listar(false);
        
        $carreasDisponibles = array();
        $fecha = new \DateTime("now");
        foreach ($carreras as $carrera) {
            
            
            if ($carrera->getFechaLimiteInscripcion() > $fecha) {
                
                
                $participantes = $this->em->getRepository(Participante::class)->listarParticipacionesDeUnaCarrera($carrera);
                if(count($participantes)< $carrera->getNumeroMaximoParticipantes()){
                  $carreasDisponibles[] = $carrera; 
                }
            }       
        }
        return new Response($this->twig->render("AppCorredoresRiojaBundle:Corredores:portada.html.twig", array('carreras' => $carreasDisponibles)));
    }

    public function carrerasAction() {
        $carrerasDisputadas = $this->em->getRepository(Carrera::class)->listar(true);
        $carrerasNoDisputadas = $this->em->getRepository(Carrera::class)->listar(false);
        
        $fecha = new \DateTime("now");
        foreach ($carrerasNoDisputadas as $carrera) {            
            
            if ($carrera->getFechaLimiteInscripcion() > $fecha) {
                
                
                $participantes = $this->em->getRepository(Participante::class)->listarParticipacionesDeUnaCarrera($carrera);
                if(count($participantes)< $carrera->getNumeroMaximoParticipantes()){
                    $carrera->setInscribirse(true);
                }else{
                    $carrera->setInscribirse(false);
                }
            }    else{
                $carrera->setInscribirse(false);
            }   
        }
        
        return new Response($this->twig->render("AppCorredoresRiojaBundle:Corredores:carreras.html.twig", array('carrerasDisputadas' => $carrerasDisputadas, 'carrerasNoDisputadas' => $carrerasNoDisputadas)));
    }

    public function detalleCarreraAction($slug) {
        $carrera = $this->em->getRepository(Carrera::class)->buscarPorSlug($slug);
        $participantes = $this->em->getRepository(Participante::class)->listarParticipacionesDeUnaCarrera($carrera);
        return new Response($this->twig->render("AppCorredoresRiojaBundle:Corredores:carrera.html.twig", array('carrera' => $carrera, 'participantes' => $participantes)));        
    }

    public function detalleOrganizacionAction() {
        return $this->render('AppCorredoresRiojaBundle:Default:index.html.twig');
    }

    public function loginAction() {   
        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->authenticationUtils->getLastUsername();
        

        // get the login error if there is one
       //$error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        //$lastUsername = $authenticationUtils->getLastUsername();
        
        return new Response($this->twig->render('AppCorredoresRiojaBundle:Corredores:login.html.twig', array(
                    'last_username' => $lastUsername,
                    'error' => $error)));
    }

    public function registroAction(Request $peticion) {
        $form = $this->formFactory->create(CorredorType::class);
        $form->handleRequest($peticion);
        if ($form->isValid()) {
            // Recogemos el corredor que se ha registrado
            $corredor = $form->getData();
            // Codificamos la contraseña del corredor
            $encoder = $this->encoderFactory->getEncoder($corredor);
            $password = $encoder->encodePassword($corredor->getPassword(), $corredor->getSalt());
            $corredor->saveEncodedPassword($password);
            // Lo almacenamos en nuestro repositorio de corredores
            $this->em->getRepository(Corredor::class)->registrar($corredor);
            //$this->get('corredorrepository')->registrar($corredor);
            // Creamos un mensaje flash para mostrar al usuario que 
            // se ha registrado correctamente
            
            $session = $peticion->getSession();     
            $session->getFlashBag()->add('info', '¡Enhorabuena, ' . $corredor->getNombre() . ' te has registrado en CorredoresPorLaRioja!');
            // Reedirigimos al usuario a la portada
            return new RedirectResponse($this->router->generate('app_corredores_rioja_homepage'));
            //return new Response($this->twig->render("AppCorredoresRiojaBundle:Corredores:portada.html.twig"));
            
        }
        return new Response($this->twig->render("AppCorredoresRiojaBundle:Corredores:registro.html.twig", array('formulario' => $form->createView())));
    }
    
    public function perfilCorredorAction(Request $peticion){
        $usuarioLogueado = $this->tokenStorage->getToken()->getUser();
        $usuario = $this->em->getRepository(Corredor::class)->buscarPorDNI($usuarioLogueado->getUsername());
        $form = $this->formFactory->create(CorredorType::class, $usuario , array('is_profile' => true));
        $form->handleRequest($peticion);
        if ($form->isValid()) {
            // Recogemos el corredor que se ha registrado
            $corredor = $form->getData();
            // Codificamos la contraseña del corredor
            if($corredor.getPassword()){
                $encoder = $this->encoderFactory->getEncoder($corredor);
                $password = $encoder->encodePassword($corredor->getPassword(), $corredor->getSalt());
                $corredor->saveEncodedPassword($password);
            }else{
                $corredor->saveEncodedPassword($usuario.getPassword());
            }
            // Lo almacenamos en nuestro repositorio de corredores
            $this->em->getRepository(Corredor::class)->actualizar($corredor);
            //$this->get('corredorrepository')->registrar($corredor);
            // Creamos un mensaje flash para mostrar al usuario que 
            // se ha registrado correctamente
            
            $session = $peticion->getSession();     
            $session->getFlashBag()->add('info', '¡Enhorabuena, ' . $corredor->getNombre() . ' te has actualizado el perfil correctamente');
            // Reedirigimos al usuario a la portada
            return new RedirectResponse($this->router->generate('app_corredores_rioja_homepage'));
            //return new Response($this->twig->render("AppCorredoresRiojaBundle:Corredores:portada.html.twig"));       
        }
        return new Response($this->twig->render("AppCorredoresRiojaBundle:Corredores:perfil.html.twig", array('formulario' => $form->createView())));
        
    }

    public function nuevoUsuarioAction() {
        return $this->render('AppCorredoresRiojaBundle:Corredores:registro.html.twig');
    }
    
    public function misCarrerasAction(){
        $usuarioLogueado = $this->tokenStorage->getToken()->getUser();
        $usuario = $this->em->getRepository(Corredor::class)->buscarPorDNI($usuarioLogueado->getUsername());
        $misCarrerasDisputadas = $this->em->getRepository(Participante::class)->listarCarrerasDeUnCorredor($usuario, true);
        $misCarrerasNoDisputadas = $this->em->getRepository(Participante::class)->listarCarrerasDeUnCorredor($usuario, false);
        return new Response($this->twig->render("AppCorredoresRiojaBundle:Corredores:miscarreras.html.twig", array('misCarrerasDisputadas' => $misCarrerasDisputadas, 'misCarrerasNoDisputadas' => $misCarrerasNoDisputadas)));
    }
    
    public function desapuntarAction($id){
        $this->em->getRepository(Participante::class)->eliminar($id);
        return new RedirectResponse($this->router->generate('app_corredores_rioja_misCarreras'));
    }
    
    public function apuntarAction($idCarrera, Request $peticion){
        $usuarioLogueado = $this->tokenStorage->getToken()->getUser();
        $corredor = $this->em->getRepository(Corredor::class)->buscarPorDNI($usuarioLogueado->getUsername());
        $corredorRegistrado = $this->em->getRepository(Participante::class)->corredorInscrito($corredor, $idCarrera);
        $session = $peticion->getSession();     
        if(!$corredorRegistrado){
            $this->em->getRepository(Participante::class)->registrar($idCarrera, $corredor);           
            $session->getFlashBag()->add('info', '¡Enhorabuena, se ha inscrito correctamente en la carrera!');            
        }else{
            $session->getFlashBag()->add('info', 'Ya estas inscrito en esta carrera');
        }
        return new RedirectResponse($this->router->generate('app_corredores_rioja_misCarreras'));
    }
    

}
