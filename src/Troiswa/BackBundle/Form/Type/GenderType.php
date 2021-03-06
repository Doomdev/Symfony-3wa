<?php
namespace Troiswa\BackBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenderType extends AbstractType
{

    private $genders;

    public function __construct($genders)
    {
        $this->genders = $genders;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
               // "choices" => [0 => "homme", 1 => "femme"]


                        "choices" => $this->genders


            ]);
    }

    public function getName()
    {
        return 'gender';
    }

    public function getParent()
    {
        return 'choice';
    }
}
