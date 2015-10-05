<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;



class MainController extends Controller
{
    public function contactAction()
    {
        //return $this->render('TroiswaBackBundle:Main:contact.html.twig');
        //return new Response("hello");
        return $this->render("TroiswaBackBundle:Other:contact.html.twig");
    }

    public function proposAction()
    {
        //return $this->render('TroiswaBackBundle:Main:contact.html.twig');
        //return new Response("hello");
        return $this->render("TroiswaBackBundle:Other:propos.html.twig");
    }

    public function aboutAction()
    {

        $products = [
            [
                "id" => 1,
                "title" => "Mon premier produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 10
            ],
            [
                "id" => 2,
                "title" => "Mon deuxième produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 20
            ],
            [
                "id" => 3,
                "title" => "Mon troisième produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 30
            ],
            [
                "id" => 4,
                "title" => "",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 410
            ],
        ];
        return $this->render("TroiswaBackBundle:Other:about.html.twig", [ "products" => $products]);
    }

    public function showAction($id)
    {

        return $this->render("TroiswaBackBundle:Other:produit.html.twig",array("id" => $id));
    }

    public function etudiantAction($prenom, $nom)
    {

        return $this->render("TroiswaBackBundle:Default:etudiant.html.twig",array("nom" => $nom,
                                                                               "prenom"=> $prenom

        ));
    }

    public function adminAction()
    {

        return $this->render("TroiswaBackBundle:Main:admin.html.twig");
    }
}
