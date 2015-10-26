<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Entity\Product;

class CartController extends Controller
{
    public function addAction(Product $product, Request $request)
    {

        $panier = $this->get('troiswa_back.cart');
        //die(dump($panier));
        $panier->add($product);
        /*
        $session = $request->getSession();

        $allProducts = [];

        if($session->get('panier')) {
            $allProducts = $session->get('panier');

        }

        // Traitement sur la quantité
        if (array_key_exists($id, $allProducts))
        {
            // $allProducts[$product->getId()]; représente la quantité du produit
            $allProducts[$id] = $allProducts[$id] + 1;

        }
        else
        {
            $allProducts[$id] = 1;
        }

        $session->set('panier', $allProducts);*/

        //die(dump($session->get('panier')));
        //dump($session);


        //$session->set('name', 'Drak');
        //$session->get('name');


        return $this->redirectToRoute('troiswa_back_page_panier');
    }

    public function panierAction(Request $request)
    {
       /* $session = $request->getSession();
        $allProducts = [];

        if($session->get('panier')){

            $em = $this->getDoctrine()->getManager();
            $allProducts = $em->getRepository("TroiswaBackBundle:Product")->findProductByIdProduct(array_keys($session->get('panier')));

        }

        //die(dump($session->get('panier')));
        return $this->render('TroiswaBackBundle:cart:panier.html.twig', ['allProducts' => $allProducts, 'quantity' => $session->get('panier')]);
       */

        $panier = $this->get('troiswa_back.cart');


        return $this->render("TroiswaBackBundle:cart:panier.html.twig",
            [
                'allProducts' => $panier->getProducts(),
                'qtyProducts' => $panier->getSessionPanier()
            ]);
    }

    public function deleteAction(Product $product, Request $request)
    {
        $session = $request->getSession();
        $cart = $session->get('panier');

        if ($cart && array_key_exists($product->getId(), $cart))
        {
            unset($cart[$product->getId()]);
            $session->set('panier', $cart);
        }

        return $this->redirectToRoute('troiswa_back_page_panier');
    }



}