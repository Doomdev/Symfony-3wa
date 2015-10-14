<?php

namespace Troiswa\BackBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('dateCreated', 'date',array("widget" => "single_text",
                                              "format" => "dd-MM-yyyy"

            ))
            ->add('quantity')
            ->add('categorie',"entity",[

                "class" => "TroiswaBackBundle:Categorie",
                "choice_label" => "title",
                "query_builder" => function(EntityRepository $er){
                    return $er->createQueryBuilder("cat")
                              ->orderBy("cat.position");
                }
            ])
            // le bouton submit est inserer dans la vue...
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\BackBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_backbundle_product';
    }
}
