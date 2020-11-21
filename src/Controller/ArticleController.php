<?php

namespace App\Controller;

use App\Entity\Articles;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles.index")
     */
    public function index(Request $request,PaginatorInterface $pagination): Response
    {
        $donnees=$this->getDoctrine()->getRepository(Articles::class)->findBy([],
            ['created_at' => 'desc']);
        $articles=$pagination->paginate($donnees,$request->query->getInt('page',1),12);
        return $this->render('article/index.html.twig', [
            'current_menu' => 'visité',
            'articles'   => $articles
        ]);
    }
}
