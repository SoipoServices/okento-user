<?php

namespace Soipo\Okento\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Soipo\Okento\UserBundle\Model\ContactableUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as JMS;

/**
 * User
 *
 * @ORM\Table("users")
 * @ORM\Entity(repositoryClass="Soipo\Okento\UserBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User extends ContactableUser
{


    /**
     * @var integer
     * @JMS\Type("integer")
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @JMS\Type("string")
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;


    /**
     * @var string
     * @JMS\Type("string")
     *
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $username;

    /**
     * @var string
     *
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @var string
     * @JMS\Type("string")
     *
     * @Assert\Length(min=8)
     * @Assert\Length(max = 4096)
     */
    protected $plainPassword;

    /**
     * @var string
     * @JMS\Type("string")
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    protected $salt;

    /**
     * @var array
     * @JMS\Type("array")
     *
     * @ORM\Column(name="roles", type="array", nullable=true)
     */
    protected $roles;

    /**
     * @var string
     * @JMS\Type("string")
     *
     * @ORM\Column(name="title", type="string", length=10, nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @JMS\Type("string")
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    protected $firstName;


    /**
     * @var string
     * @JMS\Type("string")
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    protected $lastName;


    /**
     * @var string
     * @JMS\Type("string")
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;

    /**
     * @var string
     * @JMS\Type("string")
     *
     * @ORM\Column(name="province", type="string", length=255, nullable=true)
     */
    protected $province;

    /**
     * @var string
     * @JMS\Type("string")
     *
     * @ORM\Column(name="postal_code", type="string", length=20, nullable=true)
     */
    protected $postalCode;

    /**
     * @var string
     * @JMS\Type("string")
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    protected $country;

    /**
     * @var string
     * @JMS\Type("string")
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    protected $phone;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     *
     * @ORM\Column(name="active", type="boolean", options={"default":false}, nullable=true)
     */
    protected $active;

    /**
     * @var \DateTime
     * @JMS\Type("DateTime<'Y-m-d\TH:i:sO'>")
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @JMS\Type("DateTime<'Y-m-d\TH:i:sO'>")
     *
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;


    /**
     * @var boolean
     * @JMS\Type("boolean")
     */
    protected $terms;




    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt= new \DateTime();
    }

    /**
     * Set terms
     *
     * @param string $terms
     *
     * @return User
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * Get terms
     *
     * @return string
     */
    public function getTerms()
    {
        return $this->terms;
    }
}

