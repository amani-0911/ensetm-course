<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Files;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_PROF")
 * @Route("/mesarticles")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="articles_index", methods={"GET"})
     */
    public function index(UsersRepository $usersRepository): Response
    {
             $id=($this->getUser())->getId();
        return $this->render('articles/index.html.twig', [
            'current_menu1' => 'visité',
            'user' => $usersRepository->find($id)
        ]);
    }

    /**
     * @Route("/new", name="articles_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUsers($this->getUser());
            $files=$form->get('files')->getData();

            foreach ($files as $file){
                $fiches=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('files_directory'),$fiches);
                $fil=new Files();
                $fil->setOriginalName($file->getClientOriginalName());
                $fil->setName($fiches);
                $article->addFile($fil);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('message','votre article a bien été publié');

            return $this->redirectToRoute('articles_index');
        }

        return $this->render('articles/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="articles_show", methods={"GET"})
     */
    public function show(Articles $article): Response
    {
        $url=$this->generateUrl('articles_show',['id' =>$article->getId()]);
        return $this->render('articles/show.html.twig', [
            'article' => $article,
            'url'=>$url
        ]);
    }

    /**
     * @Route("/{id}/edit", name="articles_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Articles $article): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUsers($this->getUser());
            $files=$form->get('files')->getData();
            foreach ($files as $file){
                $fiches=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('files_directory'),$fiches);
                $fil=new Files();
                $fil->setOriginalName($file->getClientOriginalName());
                $fil->setName($fiches);
                $article->addFile($fil);
            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('message','votre article a bien été modifié');

            return $this->redirectToRoute('articles_index');
        }

        return $this->render('articles/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="articles_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Articles $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('articles_index');
    }
    /**
     * @Route("/delete/file/{id}", name="articles_delete_file", methods={"DELETE"})
     */
    public function deleteImage(Request $request,Files $file): Response
    {
        $data= json_decode($request->getContent(),true);
        if ($this->isCsrfTokenValid('delete'.$file->getId(), $data['_token'])) {
            $nom = $file->getName();
            unlink($this->getParameter('files_directory') . '/' . $nom);
            $em = $this->getDoctrine()->getManager();
            $em->remove($file);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }
        return new JsonResponse(['error'=>'token invalide'],404);
    }
}
