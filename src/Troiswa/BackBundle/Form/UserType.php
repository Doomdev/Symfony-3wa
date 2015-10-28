<?php

namespace Troiswa\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troiswa\BackBundle\Form\Type\GenderType;
use Troiswa\BackBundle\Form\Type\TelType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text')
            ->add('lastname', 'text')
            ->add('email')
            ->add('login')
            ->add('password')
            ->add('password')
            ->add('gender','gender')
            ->add('adress')
            ->add('phone', new TelType())
            ->add('groupes', "entity", [
                "class" => "TroiswaBackBundle:Groupe",
                "choice_label" => "name",
                "multiple" => "true"
            ]);

        // Greffer un événement PRE_SET_DATA (avant l'affichage du formulaire)*
        // On lance la méthode editUser
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'editUser']);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\BackBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_backbundle_user';
    }

    public function editUser(FormEvent $event)
    {
        //die('ok');

        $user = $event->getData();
        $form = $event->getForm();

        //die(dump($user, $form));
        // Si j'ai un utilisateur et que l'id de l'utilisateur existe = je suis entrain de faire une modification
        if ($user && $user->getId()){
            $form->remove('login');
        }
    }


}
