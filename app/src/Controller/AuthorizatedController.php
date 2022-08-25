<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\src\Form\AlumnoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class AuthorizatedController extends AbstractController
{
    /**
     * @Route("/auth", name="auth", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $alumnos = $entityManager
              ->getRepository(Alumno::class)
              ->findAll();
              
        return $this->render('authorizated/index.html.twig', [
            'controller_name' => 'AuthorizatedController',
            'alumnos' => $alumnos
        ]);
    }

     /**
     * @Route("/deletecomplete/{id}", name="deletecomplete", methods={"GET"})
     */
    public function deleteUser(Alumno $alumno, EntityManagerInterface $doctrine)
    {
 
                $doctrine ->remove($alumno);
                $doctrine -> flush();

                $this->addFlash(
                    'info',
                    'El usuario ha sido eliminado correctamente'
               );
        
       return $this -> render("home/index.html.twig");
    }
}
