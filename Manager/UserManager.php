<?php

namespace Soipo\Okento\UserBundle\Manager;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User: soiposervices
 * Date: 24/11/15
 * Time: 00:18
 */
class UserManager
{
    protected  $objectManager;
    protected  $entityClass;
    protected  $repository;
    protected  $passwordEncoder;

    public function __construct(ObjectManager $objectManager, $entityClass = "SoipoOkentoUserBundle:User",UserPasswordEncoderInterface $passwordEncoder){
        $this->objectManager = $objectManager;
        $this->entityClass = $entityClass;
        $this->repository = $this->objectManager->getRepository($this->entityClass);
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Finds one user by the given criteria.
     *
     * @param array $criteria
     *
     * @return UserInterface
     */
    public function findUserBy(array $criteria){
        return $this->repository->findOneBy($criteria);
    }

    /**
     * Finds a user by username
     *
     * @param string $username
     *
     * @return UserInterface
     */
    public function findUserByUsername($username)
    {
        return $this->findUserBy(array('username' => $username));
    }

    /**
     * Get all users
     *
     * @return mixed
     */
    public function findAllUsers(){
        return $this->repository->findAll();
    }

    /**
     * Encode user password
     * @param $user
     */
    public function encodePassword(UserInterface $user){
        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
    }

    /**
     * Generates a random password and ecodes it
     * @param UserInterface $user
     * @return string
     */
    public function setRandomPassword(UserInterface $user) {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $password = implode($pass); //turn the array into a string

        $user->setPlainPassword($password);
        $this->encodePassword($user);

        return $password;
    }
}