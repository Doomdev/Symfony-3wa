<?php
namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troiswa\BackBundle\Entity\Categorie;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager)
    {
        /*
        $category = new Categorie();
        $category->setTitle('Catégorie hello');
        $category->setDescription('Description ');
        $category->setPosition(1);
        $category->setActive(1);
        $manager->persist($category);
        $manager->flush();

        $this->addReference("categ",$category);
         /*
        $faker = \Faker\Factory::create();

        // generate data by accessing properties
        echo $faker->name;
        die;
         */
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++)
        {
            $category = new Categorie();
            $category->setTitle($faker->text(20));
            $category->setDescription('Description ');
            $category->setPosition(1);
            $category->setActive(1);
            $category->setImage(null);
            $manager->persist($category);
            $manager->flush();
            // J'envoie toutes les catégories afin de les récupérer dans les fixtures des produits
            $this->addReference('categ_'.$i, $category);
        }




    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}