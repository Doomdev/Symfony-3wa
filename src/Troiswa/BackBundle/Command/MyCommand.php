<?php
namespace Troiswa\BackBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MyCommand extends ContainerAwareCommand
{
protected function configure()
{
    $this->setName('mycommand:test')
        ->setDescription('permet de faire une cpommande')
        ->addArgument('quantite', InputArgument::OPTIONAL,'veuillez entrer votre prenom')
        ->addOption('color','c',InputOption::VALUE_NONE,'permet de mettre de la couleur');
}

protected function execute(InputInterface $input, OutputInterface $output)
{

    //Recuperation de doctrine
    $em = $this->getContainer()->get('doctrine.orm.entity_manager');
    $quantite = $input->getArgument('quantite');
    if (!$quantite)
    {
        $quantite = 5;
    }


    $products = $em->getRepository('TroiswaBackBundle:Product')->findProductByQuantity($quantite);
    //Recuperation d'une option
    $optionColor = $input->getOption('color');


    //code
    $output->writeln('Il y a <info>'.count($products).'</info> produits qui ont une quantité inférieur à <info>'.$quantite.'</info>');

    //Recuperation du service mail
    //$this->getContainer()->get('mailer')

}
}