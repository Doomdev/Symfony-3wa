<?php
/**
 * Created by PhpStorm.
 * User: wap18
 * Date: 05/10/15
 * Time: 10:21
 */

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;



class CategorieController extends Controller
{

    public function indexAction()
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



        return $this->render("TroiswaBackBundle:Other:categorie.html.twig",array("categories" => $categories));
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

        if (array_key_exists( $id, $categories))
        {
            $oneCategprie = $categories[$id];

        }
        else
        {
            throw $this->createNotFoundException(" la categorie n'existe pas");
        }

        return $this->render("TroiswaBackBundle:Other:categoriedetail.html.twig",array("id" => $id,
                                                                                        "categorie" => $oneCategprie


        ));
    }

}
