<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\ArticleSearch;
use App\Entity\Users;
use App\Form\ArticleSearchType;
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
        $search= new ArticleSearch();
        $form=$this->createForm(ArticleSearchType::class,$search);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()) {
            $donnees = $this->getDoctrine()->getRepository(Articles::class)->findbySearch($search);
            $articles=$pagination->paginate($donnees,$request->query->getInt('page',1),12);
            return $this->render('article/index.html.twig', [
                'articles'   => $articles,
                'formSearch' => $form->createView()
                ]);

        }
        $donnees = $this->getDoctrine()->getRepository(Articles::class)->findBy([],
        ['created_at' => 'desc']);
        $articles=$pagination->paginate($donnees,$request->query->getInt('page',1),12);
        return $this->render('article/index.html.twig', [
            'current_menu' => 'visité',
            'articles'   => $articles,
            'formSearch' => $form->createView()
        ]);
    }
    /**
     * @Route("/articles/enseignant//{id}", name="enseignant")
     */
    public function ArticlesUser(Users $users,PaginatorInterface $pagination,Request $request): Response
    {

        $donnees=$users->getArticles();
        $articles=$pagination->paginate($donnees,$request->query->getInt('page',1),12);

        return $this->render('home/show.articles.user.html.twig',[
            'user' => $users,
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/articles/{module}", name="module")
     */
    public function ArticlesModule(string $module,PaginatorInterface $pagination,Request $request): Response
    {
        $search= new ArticleSearch();
       $search->setModuleSearched($module);
        $donnees = $this->getDoctrine()->getRepository(Articles::class)->findbySearch($search);
        $articles=$pagination->paginate($donnees,$request->query->getInt('page',1),12);
        return $this->render('home/show.articles.user.html.twig',[
            'module' => $module,
            'articles' => $articles
        ]);
    }


}
