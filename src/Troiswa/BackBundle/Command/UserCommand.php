<?php
namespace Troiswa\BackBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Troiswa\BackBundle\Entity\User;

class UserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('mycommand:user')
            ->setDescription('permet de creer un utilisateur')
            ->addArgument('login', InputArgument::REQUIRED,'veuilliez entrer votre login')
            ->addArgument('mdp', InputArgument::REQUIRED,'veuilliez entrer votre mot de passe');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $Login = $input->getArgument('login');
        $Mdp = $input->getArgument('mdp');


        $user = new User();

        $factory = $this->getContainer()->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user); // Je récupère l'encoder de la class Troiswa\BackBundle\Entity\User
        $newPassword = $encoder->encodePassword($Mdp, $user->getSalt());

        $user->setFirstname("John");
        $user->setLastname("Brand");
        $user->setEmail("toto12@gmail.com");
        $user->setLogin($Login);
        $user->setPassword($newPassword);
        $user->setGender(0);
        $user->setAdress("10, avenue du capitaine glarner 93400 Saint-Ouen");
        $user->setPhone("0145123269");

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $em->persist($user);
        $em->flush();

        //code
        $output->writeln('<info>Utilisateur bien créer</info>');

        //Recuperation du service mail
        //$this->getContainer()->get('mailer')

    }
}