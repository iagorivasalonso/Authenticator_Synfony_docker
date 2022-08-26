<?php

namespace App\Controller;

use App\Entity\Alumno;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;


class SecurityController extends AbstractController
{
    
    /**
     * @Route("/login", name="login")
     */
    public function renderCreateUser(AuthenticationUtils $authenticationUtils)
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
       
        return $this->render("security/login.html.twig", ['last_username' => $lastUsername, 'error' => $error]);


    }
    
     /**
     * @Route("/login/completed", name="logincomplete")
     */   

     public function userLogin(EntityManagerInterface $entityManager, Request $request, EntityManagerInterface $doctrine, UserPasswordEncoderInterface $passwordEncoder)
     {
        $alumnos = $entityManager
                     ->getRepository(Alumno::class)
                     ->findAll();


        $nombre = $request->get("username");
        $myPass = " ";
        $exist = false;
        $passwordUser =" ";
        $myPass = $request -> get("password");
        $myPassEncode =" ";

               foreach($alumnos as $alumnosearch )
               {
                     if( $alumnosearch->getUserName()==$nombre)
                     {
                         $exist = true;  
                         $passwordUser = $alumnosearch->getPassword(); 
                         $myPass = $passwordEncoder -> encodePassword($alumnosearch, $myPassEncode);
                                 
                     }   
               }    
          
              

        if($exist==true)
        {
         
            if($passwordUser != $myPass)
            {
                $login = $this->addFlash(
                    'error',
                    'La contraseña del usuario no es correcta'
                 );  
            }
        

        }else{
                      $login = $this->addFlash(
                         'error',
                         'El nombre de usuario no se encuentra en nuestra base de datos'
                      );
           
                     
        } 
     return $this->render('home/index.html.twig');   
    } 
   

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
   
    /**
     * @Route("/registro", name="registro")
     */
    public function renderCreateUserPage(AuthenticationUtils $authenticationUtils)
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
       
        return $this->render("registro.html.twig", ['last_username' => $lastUsername, 'error' => $error]);


    }
    
     /**
     * @Route("/registro/completed", name="registrocomplete")
     */   

     public function createUser(EntityManagerInterface $entityManager, Request $request, EntityManagerInterface $doctrine, UserPasswordEncoderInterface $passwordEncoder)
     {
        $alumnos = $entityManager
                     ->getRepository(Alumno::class)
                     ->findAll();

        $alumno = new Alumno();
        $alumno -> setUsername($request->get("username"));
        $alumno -> setSurname($request->get("surname"));
        $alumno -> setPassword($passwordEncoder -> encodePassword($alumno, $request -> get("password")));
        $alumno -> setAge($request->get("age"));

        $nombre = $request->get("username");

        $nuevo = true;

               foreach($alumnos as $alumnosearch )
               {
                     if( $alumnosearch->getUserName()==$nombre)
                     {
                         $nuevo = false;  
                     }   
               }    
                    
        if($nuevo==true)
        {
         
        }else{
                      $login = $this->addFlash(
                         'error',
                         'El nombre de usuario no se encuentra en la base de datos'
                      );
           
                     
        } 
        return $this->render('home/index.html.twig');
    } 
}
