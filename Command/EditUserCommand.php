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

class EditUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('okento:user:edit')
            ->setDescription('Edit user details')
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'The user username.'
            )
            ->addOption(
                'username',
                null,
                InputOption::VALUE_OPTIONAL,
                'If set, changes the user username.'
            )
            ->addOption(
                'email',
                null,
                InputOption::VALUE_OPTIONAL,
                'If set, changes the user email.'
            )
            ->addOption(
                'plainPassword',
                null,
                InputOption::VALUE_OPTIONAL,
                'If set, changes the user password.'
            )
            ->addOption(
                'firstName',
                null,
                InputOption::VALUE_OPTIONAL,
                'If set, changes the user first name.'
            )
            ->addOption(
                'lastName',
                null,
                InputOption::VALUE_OPTIONAL,
                'The user last name.'
            )
            ->addOption(
                'admin',
                null,
                InputOption::VALUE_NONE,
                'If set, gives the user admin role'
            )
            ->addOption(
                'member',
                null,
                InputOption::VALUE_NONE,
                'If set, gives the user member'
            )
            ->addOption(
                'roles',
                null,
                InputOption::VALUE_OPTIONAL,
                'If set, assign roles to user'
            )
            ->addOption(
                'active',
                null,
                InputOption::VALUE_NONE,
                'If set, active the user'
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

        if ($username = $input->getOption('username')) {
            $user->setUsername($username);
        }

        if ($email = $input->getOption('email')) {
            $user->setEmail($email);
        }

        if ($plainPassword = $input->getOption('plainPassword')) {
            $user->setPlainPassword($plainPassword);
            $userManager->encodePassword($user);
        }

        if ($firstName = $input->getOption('firstName')) {
            $user->setFirstName($firstName);
        }

        if ($lastName = $input->getOption('lastName')) {
            $user->setLastName($lastName);
        }

        $roles = array('ROLE_USER');

        if ($input->getOption('admin')) {
            $roles[] = 'ROLE_ADMIN';
        }

        if ($input->getOption('member')) {
            $roles[] = 'ROLE_MEMBER';
        }

        if  ($input->getOption('roles')) {
            $otherRoles = explode(',',$input->getOption('roles'));
            $roles = array_unique(array_merge($roles,$otherRoles));
        }

        $user->setRoles($roles);

        if ($input->getOption('active')) {
            $user->setActive(true);
        }

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->flush();

        $output->writeln('Successfully edited user: '.$user);
    }
}