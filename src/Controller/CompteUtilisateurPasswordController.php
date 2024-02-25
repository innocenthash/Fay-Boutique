<?php

namespace App\Controller;

use App\Form\ModifierPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CompteUtilisateurPasswordController extends AbstractController
{
    private $entityManager ;

    public function __construct(EntityManagerInterface $entityManager){
     $this->entityManager = $entityManager ;
    }
    #[Route('/compte/password', name: 'app_compte_utilisateur_password')]
    public function index(Request $request , UserPasswordHasherInterface $hasher): Response
    {

   $notification = null ;
        $user = $this->getUser() ;
       
        $form = $this->createForm(ModifierPasswordType::class,$user) ;
        $form->handleRequest($request) ;
        if ($form->isSubmitted() && $form->isValid()) {
            $ancien_pwd = $form->get('old_password')->getData() ;
            // dd( $user) ;
          if ($hasher->isPasswordValid($user,$ancien_pwd)) {
                 $new_pwd = $form->get('new_password')->getData() ;

                 $password = $hasher->hashPassword($user, $new_pwd) ;

                 $user->setPassword($password) ;

                 $this->entityManager->flush() ;
                 $notification = "Votre mot de passe a bien été mis à jour avec succès ✅!" ;

          } else {
                   $notification = "Votre mot de passe actuel est incorrect ❌!" ;
          }
           
        }
        return $this->render('compte_utilisateur_password/index.html.twig', [
          'form'=> $form->createView() ,
          'notification'=> $notification
        ]);
    }
}
