<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\ArticleSearch;
use App\Entity\Departements;
use App\Entity\Filieres;
use App\Form\ArticleFilereType;
use App\Form\ArticleSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="accueil")
     */
    public function index(Request $request,PaginatorInterface $pagination): Response
    {  if($this->getUser()) {
        if (($this->getUser()->getActivationToken())) {$this->addFlash('messageTou', 'une mail d\'activation a été envoyer a votre boite email ');
            return $this->redirectToRoute('app_login');
        }else{
            $search= new ArticleSearch();
            $form=$this->createForm(ArticleSearchType::class,$search);
            $form->handleRequest($request);
            if($form->isSubmitted()&& $form->isValid()){
                   $donnees=$this->getDoctrine()->getRepository(Articles::class)->findbySearch($search);
                $articles=$pagination->paginate($donnees,$request->query->getInt('page',1),12);
                return $this->render('article/index.html.twig', [
            'current_menu' => 'visité',
             'formSearch' => $form->createView() ,
            'articles'   => $articles]);

            }

       $departements= $this->getDoctrine()->getRepository(Departements::class)->findAll();
        return $this->render('home/index.html.twig',[
            'departements' => $departements,
            'formSearch' => $form->createView()
        ]);
    }}else{

            return $this->redirectToRoute('app_login');
        }

    }
    /**
     *
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
    /**
     * @Route("/Filieres/{slug}-{id}", name="Filiere")
     */
    public function showfiliere(Filieres $filiere,string $slug,PaginatorInterface $pagination,Request $request): Response
    {
        //ceci va empeche l user qui  a changé l url
        if($filiere->getSlug() !== $slug) {
            return $this->redirectToRoute('Filiere', [
                'id' => $filiere->getId(),
                'slug' => $filiere->getSlug()
            ], 301);
        }
        $search= new ArticleSearch();
        $form=$this->createForm(ArticleFilereType::class,$search);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $search->setFilieresSearched($filiere);
            $donnees=$this->getDoctrine()->getRepository(Articles::class)->findbySearch($search);
            $articles=$pagination->paginate($donnees,$request->query->getInt('page',1),12);
            return $this->render('home/show.articles.filiere.html.twig', [
                'filiere' => $filiere->getNom(),
                'departement' =>($filiere->getDepartements()),
                'formSearch' => $form->createView() ,
                'articles'   => $articles]);
        }
        $donnees=$this->getDoctrine()->getRepository(Articles::class)->findArticlesFiliere($filiere);
        $articles=$pagination->paginate($donnees,$request->query->getInt('page',1),12);

        return $this->render('home/show.articles.filiere.html.twig',[
            'filiere' => $filiere->getNom(),
            'departement' =>($filiere->getDepartements()),
            'articles' => $articles,
            'formSearch' => $form->createView()
        ]);
    }

}
