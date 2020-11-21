<?php

namespace App\Controller;


use App\Entity\Filieres;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiliereController extends AbstractController
{
    /**
     * @Route("/filieres", name="filieres")
     */
    public function index(): Response
    {


        return $this->render('filiere/index.html.twig', [

            'controller_name' => 'FiliereController',
        ]);
    }
}
