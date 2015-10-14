<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Entity\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    private $file;


    /**
     * @var string
     *
     * @ORM\Column(name="caption", type="string", length=255)
     */
    private $caption;


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
     * Set name
     *
     * @param string $name
     *
     * @return image
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set caption
     *
     * @param string $caption
     *
     * @return image
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }

    public function upload()
    {
        $nameImage = $this->file->getClientOriginalName();
        $this->file->move(__DIR__."/../../../../web/".$this->getRootWebDir(),$nameImage);
        $this->name = $nameImage;
        $this->caption = $nameImage;

    }

    public function webpath()
    {

        return $this->getRootWebDir()."/".$this->name;

    }

    private function getRootWebDir()
    {
        return "uploads/categories";
    }




}

