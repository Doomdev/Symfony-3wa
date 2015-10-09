<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Troiswa\BackBundle\Entity\Product;
use Troiswa\BackBundle\Form\ProductType;


class ProduitController extends Controller
{

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('TroiswaBackBundle:Product')
            ->find($id);

        return $this->render("TroiswaBackBundle:produit:produit.html.twig",array("id" => $id,
                                                                                "product" => $products
        ));
    }

    public function testAction()
    {

        return $this->render("TroiswaBackBundle:Other:test.html.twig");
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('TroiswaBackBundle:Product')
                       ->findAll();


        return $this->render("TroiswaBackBundle:produit:index.html.twig", array("product"=>$products));
    }



    public function editAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('TroiswaBackBundle:Product')
            ->find($id);

        $formProduct = $this->createFormBuilder($product)
            ->add('title', 'text')
            ->add("description", 'textarea')
            ->add("price")
            ->add("quantity")
            //->add("date_created", 'datetime')
            ->add("envoyer", "submit")
            ->getForm();

        $formProduct->handleRequest($request);

        if ($formProduct->isValid()) {

            //die(dump($product));
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush($product);
        }


        return $this->render("TroiswaBackBundle:produit:editproduit.html.twig", array('formProduct' => $formProduct->createview(),
            'id' => $id


        ));
    }

    public function createAction(Request $request)
    {
        $product = new Product();

        $formProduct = $this->createForm(new ProductType(), $product);

        $formProduct->handleRequest($request);

        if ($formProduct->isValid()) {

            //die(dump($product));
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush($product);
        }


        return $this->render("TroiswaBackBundle:produit:editproduit.html.twig", array('formProduct' => $formProduct->createview(),

        ));
    }

    public function deleteAction($id,Request $request)
    {
        $em =  $this->getDoctrine()->getManager();
        $product = $em->getRepository('TroiswaBackBundle:Product')->find($id);

        if(!$product) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        $session = $request->getSession();
        $session->getFlashBag()->add('success', 'Votre produit a été effaçé avec un succès');

        $em->remove($product);
        $em->flush();


        return $this->redirectToRoute("troiswa_back_page_productsindex");
    }
}
