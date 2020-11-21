<?php

namespace App\Controller;

use App\Entity\Departements;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="accueil")
     */
    public function index(): Response
    {  if($this->getUser()) {
        if (($this->getUser()->getActivationToken())) {$this->addFlash('messageTou', 'une mail d\'activation a été envoyer a votre boite email ');
            return $this->redirectToRoute('app_login');
        }else{

       $departements= $this->getDoctrine()->getRepository(Departements::class)->findAll();
        return $this->render('home/index.html.twig',[
            'departements' => $departements
        ]);
    }}else{

            return $this->redirectToRoute('app_login');
        }

    }
    /**
     * @Route("/departements/{slug}-{id}", name="departement")
     */
    public function show(Departements $departements,string $slug): Response
    {
        //ceci va empeche l user qui  a changé l url
        if($departements->getSlug() !== $slug) {
            return $this->redirectToRoute('departement', [
                'id' => $departements->getId(),
                'slug' => $departements->getSlug()
            ], 301);
        }

        return $this->render('home/show.html.twig',[
            'departements' => $departements
        ]);
    }
}
