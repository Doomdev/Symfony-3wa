<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Troiswa\BackBundle\Entity\Product;


class ProduitController extends Controller
{

    public function showAction($id)
    {

        return $this->render("TroiswaBackBundle:Other:produit.html.twig",array("id" => $id));
    }

    public function testAction()
    {

        return $this->render("TroiswaBackBundle:Other:test.html.twig");
    }

    public function createAction(Request $request)
    {

        $product =new Product();
        //$product->setTitle('hello');
        $formProduct = $this->createFormBuilder($product)
            ->add('title', 'text')
            ->add("description", 'textarea')
            ->add("price")
            ->add("quantity")
            //->add("date_created", 'datetime')
            ->add("envoyer", "submit")
            ->getForm();

        $formProduct ->handleRequest($request);

        if ($formProduct->isValid()){

            //die(dump($product));
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush($product);
        }


        return $this->render("TroiswaBackBundle:produit:createproduit.html.twig", array('formProduct' => $formProduct ->createview()));
    }
}
