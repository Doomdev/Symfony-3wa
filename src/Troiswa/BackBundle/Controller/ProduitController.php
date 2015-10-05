<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;



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
}
