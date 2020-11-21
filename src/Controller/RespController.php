<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\EditUserType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * @IsGranted("ROLE_RESP")
 * @Route("/resp", name="resp_")
 */
class RespController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('resp/index.html.twig', [
            'current_menu2' => 'visité',
            'users' => $usersRepository->findByrole("ROLE_USER")
        ]);
    }
    /**
     * modifier un utilisateur
     * @Route("/utilisateur/modifier/{id}", name="modifier_user")
     */
    public  function edituser(Users $users,Request $request){
        $form=$this->createForm(EditUserType::class,$users);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em =$this->getDoctrine()->getManager();
            $em->persist($users);
            $this->addFlash('message','utilistaeur modifié avec succés' );
            return $this->redirectToRoute('resp_index');
        }
       return $this->render('resp/editUser.html.twig',[
           'userForm' => $form->createView()
       ]);
    }
}
