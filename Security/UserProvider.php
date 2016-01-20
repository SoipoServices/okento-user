<?php

namespace Soipo\Okento\UserBundle\Security;


use Soipo\Okento\UserBundle\Entity\User;
use Soipo\Okento\UserBundle\Manager\UserManager;
use Soipo\Okento\UserBundle\Model\BaseUser;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * User: soiposervices
 * Date: 24/11/15
 * Time: 00:01
 */
class UserProvider implements UserProviderInterface
{
    protected $userManager;

    public function __construct(UserManager $userManager){
        $this->userManager = $userManager;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->userManager->findUserByUsername($username);
        if ($user) {
            return $user;
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof BaseUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Soipo\Okento\UserBundle\Model\BaseUser';
    }
}