<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     * @Assert\Length(
     *          min = 2,
     *)
     *
     * @ORM\Column(name="position", type="smallint")
     */
    private $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     *
     * @ORM\OneToOne(targetEntity="Image",cascade={"persist"})
     */
    private $image;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set title
     *
     * @param string $title
     *
     * @return categorie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return categorie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return categorie
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return categorie
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }


    /**
     * @Assert\Callback
     */
    public function istitlelenghto2caracteres(ExecutionContextInterface $context)
    {
        if (  strlen($this->getTitle()) < 2 ) {

            $context->buildViolation('Le titre contient moins de deux caracteres')
                ->atPath('title')
                ->addViolation();
        }
    }

        /**
         * @Assert\Callback
         */
        public function validate(ExecutionContextInterface $context)
        {
           /* if (($this->getDescription()) == 1) {

                $context->buildViolation('La Description ne doit pas contenir le mot ' . $this->getDecription())
                    ->atPath('description')
                    ->addViolation();
            }*/
        }

    /**
    public function __toString(){
        return $this->title;
    }
     */

    /**
     * Set image
     *
     * @param \Troiswa\BackBundle\Entity\Image $image
     *
     * @return Categorie
     */
    public function setImage(\Troiswa\BackBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Troiswa\BackBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
