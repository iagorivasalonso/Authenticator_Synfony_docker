<?php

namespace App\Controller;

use App\Entity\Alumno;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

class EditController extends AbstractController
{
    /**
     * @Route("/edit", name="edit", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $alumnos = $entityManager
              ->getRepository(Alumno::class)
              ->findAll();
              
        return $this->render('edit/index.html.twig', [
            'controller_name' => 'EditController',
            'alumnos' => $alumnos
        ]);
    }

     /**
     * @Route("/editcomplete", name="editcomplete", methods={"POST"})
     */
    public function EditUser(EntityManagerInterface $entityManager, Request $request, EntityManagerInterface $doctrine, UserPasswordEncoderInterface $passwordEncoder)
    {
 
        $entityManager = $this->getDoctrine()->getManager();

        $alumnos = $entityManager
                 ->getRepository(Alumno::class)
                 ->findAll();   

        
        $nombre =$request->get("username");
        
        $comprobAge =$request->get("age");


        foreach($alumnos as $alumno )
        {
            
            if( $alumno->getUserName()==$nombre)
            {
                $alumno ->setUsername($request->get("username"));
                $alumno ->setSurname($request->get("surname"));
               
                     if(intVal($comprobAge))
                     {
                          $alumno ->setAge($request->get("age"));
                          $doctrine -> persist($alumno);
                          $doctrine -> flush();

                          $this->addFlash(
                                   'info',
                                   'El usuario ha sido editado correctamente'
                                     );

                     }else{
                       
                           $this->addFlash(
                                'error',
                                'Uno de los campos es erroneo'
                                 );  
                      }
            }
                
        }

        return $this->render('edit/index.html.twig', [
            'controller_name' => 'EditController',
            'alumnos' => $alumnos,
        ]); 
    }
}
