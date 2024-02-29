<?php

namespace App\ClassPanier;

use Symfony\Component\HttpFoundation\RequestStack;

class Panier
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function add($id)
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();

        $panier = $session->get('panier', []);

   if(!empty($panier[$id])){
       $panier[$id]++ ;
   } else {
    $panier[$id] = 1 ;
   }
        // Mettre à jour le panier dans la session
        $session->set('panier', $panier);
    }

    public function get()
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
        return $session->get('panier', []);
    }

    public function remove()
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
        $session->remove('panier');
    }

    public function supprimer($id)
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
       $panier = $session->get('panier', []);

        unset($panier[$id]);
        $session->set('panier', $panier);
    }
    public function decrementer($id) {
        $request = $this->requestStack->getCurrentRequest() ;
        $session = $request->getSession() ;

        $panier = $session->get('panier',[]) ;

        if ($panier[$id]>1) {
            $panier[$id]-- ;
        } else {
            unset($panier[$id]) ;
        }

        $session->set('panier',$panier) ;
    }

    public function incrementer($id) {
        $request = $this->requestStack->getCurrentRequest() ;
        $session = $request->getSession() ;

        $panier = $session->get('panier',[]) ;

        if ($panier[$id]>0) {
            $panier[$id]++;
        } else {
            unset($panier[$id]) ;
        }

        $session->set('panier',$panier) ;
    }
}