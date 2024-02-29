<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\CommandeType;
use App\ClassPanier\Panier;
use App\Entity\Commande;
use App\Entity\DetailsCommande;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CommandeController extends AbstractController
{
    private $entityManager ;
    public function __construct(EntityManagerInterface $entityManager)
    {
       $this->entityManager =  $entityManager ;
    }
    #[Route('/commande', name: 'app_commande')]
    public function index(Panier $panier): Response
    {
        $PanierSurMonCompte = [] ;

       foreach ( $panier->get() as $id => $quantity) {

        $PanierSurMonCompte[] = [
               'produit'=>$this->entityManager->getRepository(Produit::class)->findOneById($id) ,
               'quantite'=> $quantity 
        ] ;
       }
        // dd($this->getUser()->getAdresses()->getValues()) ;
        $form = $this->createForm(CommandeType::class,null ,
        ['user' => $this->getUser()
        ]) ;
        if (!$this->getUser()->getAdresses()->getValues()) {
            return  $this->redirectToRoute('app_addresse');
        }
        return $this->render('commande/index.html.twig', [
             'form'=>$form->createView(),
             'mon_panier' =>  $PanierSurMonCompte,
        ]);
    }

    #[Route('/commande/recap', name: 'recap_commande')]
    public function ajouter(Panier $panier , Request $request): Response
    {
        $PanierSurMonCompte = [] ;

       foreach ( $panier->get() as $id => $quantity) {

        $PanierSurMonCompte[] = [
               'produit'=>$this->entityManager->getRepository(Produit::class)->findOneById($id) ,
               'quantite'=> $quantity 
        ] ;
       }
        // dd($this->getUser()->getAdresses()->getValues()) ;
        $form = $this->createForm(CommandeType::class,null ,
        ['user' => $this->getUser()
        ]) ;
        $form->handleRequest($request) ;

        if ($form->isSubmitted() && $form->isValid()) {
     $date_actuel = new DateTime()    ;
     //  dd($form ;
    //  dd($date_actuel ) ;

    $livreurs = $form->get('livreurs')->getData() ;
    $adresses = $form->get('adresses')->getData() ;
    
    $adresses_total =  $adresses->getNomplacement().'--'.$adresses->getVille().'--'.$adresses->getRepere() ;

    $commande = new Commande() ;
 $commande->setUser($this->getUser()) ;
 $commande->setCreatedAt($date_actuel) ;
 $commande->setNomLivraison($livreurs->getNom()) ;
 $commande->setAdresseLivraison($adresses_total) ;
 $commande->setPrixLivraison($livreurs->getPrix()) ;
 $commande->setIsPaid(0) ;
    // dd($adresses_total ) ;

   $this->entityManager->persist($commande) ;

   foreach ($PanierSurMonCompte as $produit) {
   
    $details = new DetailsCommande() ;

    $details->setLesCommandes($commande) ;
    $details->setProduit($produit['produit']->getNom()) ;
    $details->setQuantite($produit['quantite']) ;
    $details->setPrix($produit['produit']->getPrix()) ;
    $details->setTotal($produit['produit']->getPrix()*$produit['quantite']) ;

    $this->entityManager->persist($details) ;
    // dd($details) ;
   }
   
   $this->entityManager->flush() ;
   return $this->render('commande/add.html.twig', [
    'livreurs' => $livreurs ,
      'adresses'=> $adresses_total ,
     'mon_panier' =>  $PanierSurMonCompte,
]);
        }

        return $this->redirectToRoute('panier');
        
    }
}
