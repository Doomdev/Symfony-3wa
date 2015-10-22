<?php

namespace Troiswa\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troiswa\BackBundle\Form\DataTransformer\TagTransformer;

class MarqueType extends AbstractType
{

    private $em;

    public function __construct($doctrine = null)
    {
        $this->em = $doctrine;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre');

            $builder->add(
                $builder->create('tags','collection',array(
                    'type'=>new TagsTypeWithoutMarque(),
                    "allow_add" => true

                ))->addModelTransformer(new TagTransformer($this->em))
            );
            /*
            ->add('tags', "entity", [
                "class" => "TroiswaBackBundle:Tags",
                "choice_label" => "nom",
                "multiple" => "true"
            ])
            */;


    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\BackBundle\Entity\Marque'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_backbundle_marque';
    }

}
