<?php
/**
 * Created by PhpStorm.
 * User: wap18
 * Date: 05/10/15
 * Time: 10:21
 */

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Troiswa\BackBundle\Entity\Categorie;
use Troiswa\BackBundle\Form\CategorieType;


class CategorieController extends Controller
{

    public function indexAction()
    {
       /* $categories = [
            1 => [
                "id" => 1,
                "title" => "Homme",
                "description" => "lorem ipsum \n suite du contenu",
                "date_created" => new \DateTime('now'),
                "active" => true
            ],
            2 => [
                "id" => 2,
                "title" => "Femme",
                "description" => "<strong>lorem</strong> ipsum",
                "date_created" => new \DateTime('-10 Days'),
                "active" => true
            ],
            3 => [
                "id" => 3,
                "title" => "Enfant",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('-1 Days'),
                "active" => false
            ],
        ];*/



        return $this->render("TroiswaBackBundle:categorie:index.html.twig");
    }


    public function categorieAction(Categorie $categorie)
    {




        return $this->render("TroiswaBackBundle:categorie:categorie.html.twig",["categorie"=>$categorie]);
    }

    public function createAction(Request $request)
    {
        $category = new Categorie();
        $form = $this->createForm(new CategorieType(), $category)
                            ->add('save', 'submit');
        $form->handleRequest($request);
        if($form->isValid())
        {


            $image = $category->getImage();
            $image->upload();
            $em = $this->getDoctrine()->getManager();
            //Je supprime les 2 lignes en dessous car cascade persit dans l'entity category
            //$em->persist($image);
            //$em->flush();
            $em->persist($category);
            $em->flush();
        }

        return $this->render("TroiswaBackBundle:categorie:createcategorie.html.twig", ['formCategory' => $form->createView()]);
    }

    public function editAction()
    {




        return $this->render("TroiswaBackBundle:categorie:editcategorie.html.twig");
    }

    public function deleteAction()
    {




        return $this->render("TroiswaBackBundle:categorie:deletecategorie.html.twig");
    }



    public function showAction($id)
    {
        $categories = [
            1 => [
                "id" => 1,
                "title" => "Homme",
                "description" => "lorem ipsum \n suite du contenu",
                "date_created" => new \DateTime('now'),
                "active" => true
            ],
            2 => [
                "id" => 2,
                "title" => "Femme",
                "description" => "<strong>lorem</strong> ipsum",
                "date_created" => new \DateTime('-10 Days'),
                "active" => true
            ],
            3 => [
                "id" => 3,
                "title" => "Enfant",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('-1 Days'),
                "active" => false
            ],
        ];

        if (array_key_exists($id, $categories)) {
            $oneCategprie = $categories[$id];

        } else {
            throw $this->createNotFoundException(" la categorie n'existe pas");
        }

        return $this->render("TroiswaBackBundle:Other:categoriedetail.html.twig", array("id" => $id,
            "categorie" => $oneCategprie


        ));
    }

        public function renderAllCategorieAction(){

        $em = $this->getDoctrine()->getManager();

        $categorie = $em->getRepository("TroiswaBackBundle:Categorie")->findAll();

        return $this->render("TroiswaBackBundle:categorie:rendercategorie.html.twig",array("categorie" => $categorie));

        }

}
