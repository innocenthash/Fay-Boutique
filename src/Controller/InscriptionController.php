<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(): Response
    {
        $user = new User() ;
        $form = $this->createForm(InscriptionType::class,$user) ;
        return $this->render('inscription/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
