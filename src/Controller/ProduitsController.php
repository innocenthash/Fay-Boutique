<?php

namespace App\Controller;


use App\Entity\Produit;
use App\Form\RechercheType;
use App\ClassRecherche\Recherche;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitsController extends AbstractController
{
    private $entityManager ;
    public function __construct(EntityManagerInterface $entityManager)
    {
         $this->entityManager = $entityManager ;
    }
    #[Route('/produits', name: 'app_produits')]
    public function index(Request $request): Response
    {

        $recherche = new Recherche() ;
        $produits =  $this->entityManager->getRepository(Produit::class)->findAll() ;
        $form  = $this->createForm(RechercheType::class,$recherche) ;
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            // $recherche = $form->getData() ;
            $produits = $this->entityManager->getRepository(Produit::class)->findWithRecherche($recherche) ;
            // dd($recherche) ;
        }
        return $this->render('produits/index.html.twig', [
           'produits'=> $produits ,
           'form'=>$form->createView()
        ]);
    }

    #[Route('/produits/affiche-specifique/{slug}', name: 'app_produits_sprecifique')]
    public function afficheUnique($slug){
     $produit = $this->entityManager->getRepository(Produit::class)->findOneBySlug($slug) ;
         if(!$produit) {
            return $this->redirectToRoute('app_produits') ;
         }

     return $this->render('produits/afficheUnique.html.twig', [
            'produit'=> $produit ,
         ]);
    }
}
