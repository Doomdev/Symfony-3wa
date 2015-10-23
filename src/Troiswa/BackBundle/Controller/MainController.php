<?php

namespace Troiswa\BackBundle\Controller;

use MetzWeb\Instagram\Instagram;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Tests\FilesystemTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;



class MainController extends Controller
{
    public function contactAction(Request $request)
    {
        //return $this->render('TroiswaBackBundle:Main:contact.html.twig');
        //return new Response("hello");
        $formulaireContact = $this->createFormBuilder()
            ->add("firstname", "text",
                [
                    "constraints" =>
                        [
                            new Assert\NotBlank(),
                            new Assert\Range(
                                [
                                    'min' => 2,
                                ]
                            )
                        ],
                    "required"=>true
                ]
            )
            ->add("lastname", "text",["constraints" =>
                        [
                            new Assert\NotBlank(),

                        ],
                "required"=>true])
            ->add("Email", "email"

            )
            ->add("Content", "text",
                [
                    "constraints" =>
                        [
                            new Assert\NotBlank(),
                            new Assert\Range(
                                [
                                    'min' => 10,
                                    'max' => 100,
                                ])


                        ],
                    "required"=>true])
            ->add("send", "submit")
            ->getform();


        $formulaireContact->handlerequest($request);
        {

            if($formulaireContact->isValid())

            {
                $data = $formulaireContact->getData();
                $message = \Swift_Message::newInstance()
                    ->setSubject('Hello Email')
                    ->setFrom('lamerant.matthieu@gmail.com')
                    ->setTo('roadsteur@gmail.com')
                    ->setBody(
                        $this->renderView(

                            'TroiswaBackBundle:Email:contact.html.twig', array('data' => $data)
                        ),
                        'text/html'
                    );
             $this->get('mailer')->send($message);
                $this->get('session')->getFlashBag()
                     ->add('success_contact', "le mail a bien été envoyé");


             return $this->redirectToRoute("troiswa_back_page_contact");

            }

        }


        return $this->render("TroiswaBackBundle:Other:contact.html.twig", ['formContact' => $formulaireContact->createView()

        ]);
    }

    public function feedbackAction(Request $request)
    {

        $formulaireContact = $this->createFormBuilder()
            ->add("url", "url",
                [
                    "constraints" =>
                        [
                            new Assert\NotBlank()
                        ]
                ])
            ->add("Bugstatus", "choice", array(
                'choices'=>
                    array(
                        "bug1" => "bug-classique" ,
                        "bug2" => "bug-moyen",
                        "bug3" => "bug-fort"),
                'preferred_choices'=>array('bug-classique'),
                "constraints" =>
                    [
                        new Assert\NotBlank()

                    ]))
            ->add("Firstname", "text")

            ->add("Email", "email"

                )
            ->add("date", "date", ['years' => range(date('Y')-1,date('Y'))],
                [
                    "constraints" =>
                        [
                            new Assert\NotBlank(),
                            new Assert\Date()

                        ],
                    "required"=>true
                ]


                )
            ->add("send", "submit")
            ->getform();

        if ("POST" === $request->getMethod())
        {

            $formulaireContact->bind($request);
            if ($formulaireContact->isValid())
            {

            }
        }


        return $this->render("TroiswaBackBundle:Other:feedback.html.twig", ['formContact' => $formulaireContact->createView()

        ]);

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

        $utility = $this->get('troiswa_back.util');
        echo $utility->slugify('salut ludo');
        echo '<br>';
        echo $utility->getText();
        dump($utility);
        die;
        //dump($this->getDoctrine()->getManager());
        //dump($this->getDoctrine()->getManager());
        //die;
        //$mesImages = $instagram->getUserMedia($this->getParameter('id_instagram'));
        //die(dump($instagram->getLoginUrl()));
        //$instagram->setAccessToken($this->getParameter('token_instagram'));
        //die(dump($instagram->getPopularMedia()));
       /* foreach($instagram->getPopularMedia()->data as $media)
        {
            //die(dump($media));
            echo "<img src='".$media->images->thumbnail->url."'>";
            //die;
        }*/

        //die(dump($mesImages));
        // création du fichier
        /*
        $fs->touch($file);
        // insertion dans le
        $fs->dumpFile($file, serialize($mesImages));*/

        // Nom du fichier
        $file = __DIR__."/../../../../app/cache/cache_instagram.txt";
        $fs = new Filesystem();
        $timeCache = time() - (1 * 60 );

        //dump(date ("F d Y H:i:s.", filemtime($file)));
        //dump(date ("F d Y H:i:s.", $timeCache));

        //die(dump($timeCache, filemtime($file)));

        // filemtime lit la date de dernière modification du fichier
        if ($fs->exists($file) && ( filemtime($file) >  $timeCache) ){

            // Récupération du contenu du fichier cacheinstagram
            $mesImages = unserialize(file_get_contents($file));
           // dump(file_get_contents($file));
            //dump($mesImages);
           // die('Utilisation du cache');
        }
        else{
            //die(dump($this->getParameter('client_id_instagram')));
            $instagram = new Instagram(array(
                'apiKey'      => $this->getParameter('client_id_instagram'),
                'apiSecret'   => $this->getParameter('client_secret_instagram'),
                'apiCallback' => $this->getParameter('callback_instagram')
            ));

            $instagram->setAccessToken($this->getParameter('token_instagram'));

            $mesImages = $instagram->getUserMedia($this->getParameter('id_instagram'));

            // Création du fichier et ajout des minutes du cache
            $fs->touch($file);
            // insertion dans le
            $fs->dumpFile($file, serialize($mesImages));
            //die(dump($mesImages));

        }


        $em = $this->getDoctrine()
                   ->getManager();

        $productAll = $em->getRepository("TroiswaBackBundle:Product")
                        // ->findAll()
                         ->findAllPerso();

        //dump($productAll)

        $product = $em->getRepository("TroiswaBackBundle:Product")
            // equivalent de ->find(id)
            ->findPerso(14);
       // die(dump($product));

        $em->getRepository("TroiswaBackBundle:Product")
        ->findProductByAccueil('Accueil');

        return $this->render("TroiswaBackBundle:Main:admin.html.twig", ["mesImages" => $mesImages->data]);

    }
}
