<?php
namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troiswa\BackBundle\Entity\Product;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /*
        $product = new Product();
        $product->setTitle('Catégorie hello');
        $product->setDescription('Description ');
        $product->setPrice(456);
        $product->setQuantity(456);
        $categories = $this->getReference("categ");
        $product->setCategorie($categories);
        $manager->persist($product);
        $manager->flush();

        */

        $faker = \Faker\Factory::create('fr_FR');

        // generate data by accessing properties
        /*
        echo $faker->name;
        die;
        */


        for ($i = 0; $i < 10; $i++){

            $product = new Product();
            $product->setTitle($faker->text(10));
            $product->setDescription($faker->text());
            $product->setQuantity($faker->randomDigitNotNull);
            $product->setPrice($faker->randomFloat(2,0,1000));
            $category=$this->getReference("categ");
            $product->setCategorie($category);
            $product->setMarque($manager->getRepository('TroiswaBackBundle:Marque')->find(1));
            $manager->persist($product);
            $manager->flush();
        }



    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}