<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteUtilisateurController extends AbstractController
{
    #[Route('/compte_utilisateur', name: 'app_compte_utilisateur')]
    public function index(): Response
    {
        return $this->render('compte_utilisateur/index.html.twig', [
           
        ]);
    }
}
