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
        $category = new Categorie();
        $category->setTitle('Catégorie hello');
        $category->setDescription('Description ');
        $category->setPosition(1);
        $category->setActive(1);
        $manager->persist($category);
        $manager->flush();

        $this->addReference("categ",$category);
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