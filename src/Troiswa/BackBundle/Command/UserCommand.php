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

        //Recuperation de doctrine
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $user = new User();
        $user->setFirstname("John");
        $user->setLastname("Brand");
        $user->setEmail("roadsteur@gmail.com");
        $user->setLogin($input->getArgument('login'));
        $user->setPassword($input->getArgument('mdp'));
        $user->setGender(0);
        $user->setAdress("10, avenue du capitaine glarner 93400 Saint-Ouen");
        $user->setPhone("0145123269");

        $em->persist($user);
        $em->flush();

        //code
        $output->writeln('<info>Utilisateur bien créer</info>');

        //Recuperation du service mail
        //$this->getContainer()->get('mailer')

    }
}