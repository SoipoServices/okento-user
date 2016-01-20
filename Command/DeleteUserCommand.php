<?php
/**
 * Created by PhpStorm.
 * User: soiposervices
 * Date: 29/11/15
 * Time: 12:58
 */

namespace Soipo\Okento\UserBundle\Command;


use Soipo\Okento\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('okento:user:delete')
            ->setDescription('Delete user')
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'The user username.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $userManager = $this->getContainer()->get('soipo_okento_user.manager.user');
        $user = $userManager->findUserByUsername($username);

        if(!$user){
            $output->writeln('Could not find user: '.$username);
            return;
        }

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->remove($user);
        $em->flush();

        $output->writeln('Successfully removed user: '.$user);
    }
}