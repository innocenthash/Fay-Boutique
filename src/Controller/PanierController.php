<?php

namespace App\Controller;



use App\ClassPanier\Panier;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PanierController extends AbstractController
{
    private $entityManager ;
    public function __construct(EntityManagerInterface $entityManager)
    {
       $this->entityManager =  $entityManager ;
    }
    #[Route('/panier', name: 'app_panier')]
    public function index(Panier $panier): Response
    {

       $PanierSurMonCompte = [] ;

       foreach ( $panier->get() as $id => $quantity) {

        $PanierSurMonCompte[] = [
               'produit'=>$this->entityManager->getRepository(Produit::class)->findOneById($id) ,
               'quantité'=> $quantity 
        ] ;
       }
        return $this->render('panier/index.html.twig', [
            'mon_panier' =>  $PanierSurMonCompte,
        ]);
    }

    #[Route('/panier/ajouter/{id}', name: 'app_panier_ajouter')]
    public function ajouter(Panier $panier,$id): Response
    {

        $panier->add($id) ;

        return $this->redirectToRoute('app_panier') ;
    }

    #[Route('/panier/supprimer', name: 'app_panier_supprimer')]
    public function supprimer(Panier $panier): Response
    {

        $panier->remove() ;

        return $this->redirectToRoute('app_produits') ;
    }

    #[Route('/panier/supprimerUnProduit/{id}', name: 'app_panier_supprimer_unproduit')]
    public function supprimerUnProduit(Panier $panier,$id): Response
    {

        $panier->supprimer($id) ;

        return $this->redirectToRoute('app_panier') ;
    }

    #[Route('/panier/decrementerUnProduit/{id}', name: 'app_panier_decrementer_unproduit')]
    public function decrementerUnProduit(Panier $panier,$id): Response
    {

        $panier-> decrementer($id) ;

        return $this->redirectToRoute('app_panier') ;
    }
    #[Route('/panier/incrementerUnProduit/{id}', name: 'app_panier_incrementer_unproduit')]
    public function incrementerUnProduit(Panier $panier,$id): Response
    {

        $panier-> incrementer($id) ;

        return $this->redirectToRoute('app_panier') ;
    }
}
