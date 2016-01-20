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

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('okento:user:create')
            ->setDescription('Creates a new user')
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'The user username.'
            )
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'The user email.'
            )
            ->addArgument(
                'plainPassword',
                InputArgument::REQUIRED,
                'The user password.'
            )
            ->addArgument(
                'firstName',
                InputArgument::REQUIRED,
                'The user first name.'
            )
            ->addArgument(
                'lastName',
                InputArgument::REQUIRED,
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
        $email = $input->getArgument('email');
        $plainPassword = $input->getArgument('plainPassword');
        $firstName = $input->getArgument('firstName');
        $lastName = $input->getArgument('lastName');

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);

        $user->setPlainPassword($plainPassword);
        $this->getContainer()->get('soipo_okento_user.manager.user')->encodePassword($user);


        if ($firstName) {
            $user->setFirstName($firstName);
        }

        if($lastName){
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
        $em->persist($user);
        $em->flush();

        $output->writeln('Successfully created user: '.$user);
    }
}