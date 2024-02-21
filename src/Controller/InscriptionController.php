<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionController extends AbstractController
{
    private $entityManager ;
    public function __construct(EntityManagerInterface $entityManager)
    {
       $this->entityManager =  $entityManager ;
    }
    #[Route('/inscription', name: 'app_inscription')]

   
    public function index(Request $request , UserPasswordHasherInterface $hacher): Response
    {
        $user = new User() ;
        $form = $this->createForm(InscriptionType::class,$user) ;

        $form->handleRequest($request) ;

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData() ;
            $password = $hacher->hashPassword($user,$user->getPassword()) ;
            $user->setPassword($password) ;
            $this->entityManager->persist($user) ;
            $this->entityManager->flush() ;

        }

        return $this->render('inscription/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
