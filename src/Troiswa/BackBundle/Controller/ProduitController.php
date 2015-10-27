<?php

namespace Troiswa\BackBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Troiswa\BackBundle\Entity\Commentaire;
use Troiswa\BackBundle\Entity\Product;
use Troiswa\BackBundle\Form\CommentaireType;
use Troiswa\BackBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ProduitController extends Controller
{

    /**
     *
     * @ParamConverter("products", options={"repository_method" = "findProductWithComment"})
     */
    public function showAction($id,Request $request, Product $products)
    {
        $em = $this->getDoctrine()->getManager();
        /*$products = $em->getRepository('TroiswaBackBundle:Product')
            ->find($id);*/

        $comment = new Commentaire();
        $comment->setProduct($products);

        $formCommentaire = $this->createForm(new CommentaireType(), $comment);

        $formCommentaire->handleRequest($request);

        if ($formCommentaire->isValid()) {

            //die(dump($product));
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush($comment);
        }


        $commentaire = $em->getRepository('TroiswaBackBundle:Commentaire')
            ->findBy(["product" => $products, 'active' => 1], ["dateCreation" => "DESC"]);





        return $this->render("TroiswaBackBundle:produit:produit.html.twig",array("id" => $id,
                                                                                "product" => $products,
                                                                                'formCommentaire' => $formCommentaire->createview(),
                                                                                "commentaire" =>$commentaire

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
                       //->findAll();
                        ->findAllProdctCategory();

        //$paginator  = $this->get('knp_paginator');
        //$pagination = $paginator->paginate(
           // $query,
          //  $request->query->getInt('page', 1)/*page number*/
            //10/*limit per page*/


        //);



        return $this->render("TroiswaBackBundle:produit:index.html.twig", array("product"=>$products,

        ));
    }


    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
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
            ->add('dateCreated', 'date',array("widget" => "single_text",
                "format" => "dd-MM-yyyy"

            ))
            ->add('categorie',"entity",[

                "class" => "TroiswaBackBundle:Categorie",
                "choice_label" => "title",
                "query_builder" => function(EntityRepository $er){
                    return $er->createQueryBuilder("cat")
                        ->orderBy("cat.position");
                }
            ])
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

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, "Vous n'avez l'autorisation pour accéder à cette page");
        /* Même chose
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
    	throw $this->createAccessDeniedException('Vous n'avez l'autorisation pour accéder à cette page');
         }
        */
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

        if($request->isXmlHttpRequest())
        {
            return new JsonResponse();
        }



        return $this->redirectToRoute("troiswa_back_page_productsindex");
    }
}
