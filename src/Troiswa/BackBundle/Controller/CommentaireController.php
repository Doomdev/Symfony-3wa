<?php

namespace Troiswa\BackBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Troiswa\BackBundle\Entity\Commentaire;




class CommentaireController extends Controller
{


    public function commentaireAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository('TroiswaBackBundle:Commentaire')
            ->findAll();


        return $this->render("TroiswaBackBundle:Commentaire:commentaire.html.twig", array("commentaire" =>$commentaire


        ));
    }

    public function checkboxAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository('TroiswaBackBundle:Commentaire')
                          ->find($id);
        if($commentaire->getActive() == 1){

            $commentaire->setActive(0);
        }else{
            $commentaire->setActive(1);

        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($commentaire);
        $em->flush($commentaire);

        return $this->redirectToRoute("troiswa_back_page_commentaire_index");

    }



}
