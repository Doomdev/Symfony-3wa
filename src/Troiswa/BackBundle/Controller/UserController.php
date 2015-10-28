<?php

namespace Troiswa\BackBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Entity\User;
use Troiswa\BackBundle\Form\UserType;


class UserController extends Controller
{
    public function enregistrementAction(Request $request)
    {


        $user = new User();
        $form = $this->createForm(new UserType(), $user)
                ->add('enregistrer', 'submit');
        $form->handleRequest($request);
        //$form->add('submit', 'submit', array('label' => 'Create'));

        if ($form->isValid()) {


            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user); // Je récupère l'encoder de la class Troiswa\BackBundle\Entity\User
            $newPassword = $encoder->encodePassword($user->getPassword(), $user->getSalt());


            $user->setPassword($newPassword);



            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }




        return $this->render('TroiswaBackBundle:register:register.html.twig', array(
            'form'   => $form->createView(),
        ));




    }
}

