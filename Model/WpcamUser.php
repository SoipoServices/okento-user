<?php
/**
 * Created by PhpStorm.
 * User: soiposervices
 * Date: 03/12/15
 * Time: 20:21
 */

namespace Soipo\Okento\UserBundle\Model;



trait WpcamUser
{
    /**
     * @var string
     *
     * @ORM\Column(name="second_name", type="string", length=255, nullable=true)
     */
    protected $secondName;

    /**
     * @var string
     *
     * @ORM\Column(name="affiliation", type="string", length=255 , nullable=true)
     */
    protected $affiliation;


    /**
     * @var string
     *
     * @ORM\Column(name="association", type="boolean", nullable=true)
     */
    protected $association;

    /**
     * @var string
     *
     * @ORM\Column(name="association_code", type="string", length=255, nullable=true)
     */
    protected $associationCode;

    /**
     * @var string
     *
     * @ORM\Column(name="association_province", type="string", length=255, nullable=true)
     */
    protected $associationProvince;

    /**
     * Set association
     *
     * @param string $association
     *
     * @return User
     */
    public function setAffiliation($affiliation)
    {
        $this->affiliation = $affiliation;

        return $this;
    }

    /**
     * Get affiliation
     *
     * @return string
     */
    public function getAffiliation()
    {
        return $this->affiliation;
    }


    /**
     * Set secondName
     *
     * @param string $secondName
     *
     * @return BaseUser
     */
    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;

        return $this;
    }

    /**
     * Get secondName
     *
     * @return string
     */
    public function getSecondName()
    {
        return $this->secondName;
    }

    /**
     * Set association
     *
     * @param string $association
     *
     * @return User
     */
    public function setAssociation($association)
    {
        $this->association = $association;

        return $this;
    }

    /**
     * Get association
     *
     * @return string
     */
    public function getAssociation()
    {
        return $this->association;
    }


    /**
     * Set associationCode
     *
     * @param string $associationCode
     *
     * @return User
     */
    public function setAssociationCode($associationCode)
    {
        $this->associationCode = $associationCode;

        return $this;
    }

    /**
     * Get associationCode
     *
     * @return string
     */
    public function getAssociationCode()
    {
        return $this->associationCode;
    }

    /**
     * Set associationProvince
     *
     * @param string $associationProvince
     *
     * @return User
     */
    public function setAssociationProvince($associationProvince)
    {
        $this->associationProvince = $associationProvince;

        return $this;
    }

    /**
     * Get associationProvince
     *
     * @return string
     */
    public function getAssociationProvince()
    {
        return $this->associationProvince;
    }

}