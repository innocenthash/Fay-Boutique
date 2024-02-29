<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Form\AdresseType;
use App\ClassPanier\Panier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdresseController extends AbstractController
{

    private $entityManager ;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager ;
    }
    #[Route('/adresse', name: 'app_adresse')]
    public function index(): Response
    {
        return $this->render('adresse/index.html.twig', [
           
        ]);
    }

    #[Route('/adresse/ajouter', name: 'app_adresse_ajouter')]
    public function ajouter(Panier $panier ,Request $request): Response
    {

        $adresse = new Adresse() ;

        $form = $this->createForm(AdresseType::class,$adresse) ;

        $form->handleRequest($request) ;

        if ($form->isSubmitted() && $form->isValid()) {
        $adresse->setUser($this->getUser()) ;
        $this->entityManager->persist($adresse) ;
        $this->entityManager->flush() ;

        if ($panier->get()) {
                return $this->redirectToRoute('app_commande');
        }

        return $this->redirectToRoute('app_adresse') ;
        // dd($adresse) ;
        }
        // $adresse = new Adresse() ;
        // $form = $this->createForm(AdresseType::class,$adresse) ;
        return $this->render('adresse/ajouter.html.twig', [
               'form'=> $form->createView()
        ]);
    }

    #[Route('/adresse/modifier/{id}', name: 'app_adresse_modifier')]
    public function modifier(Request $request,$id): Response
    {

$adresse= $this->entityManager->getRepository(Adresse::class)->findOneById($id) ;

$form = $this->createForm(AdresseType::class, $adresse) ;

$form->handleRequest($request) ;

if (!$adresse || $adresse->getUser() != $this->getUser()) {
    return $this->redirectToRoute('app_adresse') ;
}

if ($form->isSubmitted() && $form->isValid()) {
    $this->entityManager->flush() ;
    return $this->redirectToRoute('app_adresse') ;
}

        return $this->render('adresse/modifier.html.twig', [
           'form'=>$form->createView() 
        ]);
    }

    #[Route('/adresse/supprimer/{id}', name: 'app_adresse_supprimer')]
    public function supprimer(Request $request,$id): Response
    {

$adresse= $this->entityManager->getRepository(Adresse::class)->findOneById($id) ;





if (!$adresse || $adresse->getUser() != $this->getUser()) {
    return $this->redirectToRoute('app_adresse') ;
}


    $this->entityManager->remove($adresse) ;
    $this->entityManager->flush() ;
    return $this->redirectToRoute('app_adresse') ;

    }
}
