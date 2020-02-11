<?php

namespace Application\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 *
 *
 * @ORM\Table(name="CR__User_CRInfo")
 * @ORM\Entity(repositoryClass="CRInfoRepository")
 * @Serializer\ExclusionPolicy("all")
 * @Gedmo\Loggable
 */
class CRInfo extends BaseEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Serializer\Expose
     */
    private $id;


    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Serializer\Expose
     */
    private $role;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     */
    private $expLevel = 0;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $trophies;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $donations = 0;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $donationsReceived = 0;
    /**
     * @var integer
     *
     * @ORM\Column(type="float", nullable=true)
     *
     * @Serializer\Expose
     */
    private $donationsPercent = 0;


    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Serializer\Expose
     */
    private $arenaName;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rank.
     *
     * @param int|null $rank
     *
     * @return CRInfo
     */
    public function setRank($rank = null)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank.
     *
     * @return int|null
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set role.
     *
     * @param string|null $role
     *
     * @return CRInfo
     */
    public function setRole($role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return string|null
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set expLevel.
     *
     * @param int $expLevel
     *
     * @return CRInfo
     */
    public function setExpLevel($expLevel)
    {
        $this->expLevel = $expLevel;

        return $this;
    }

    /**
     * Get expLevel.
     *
     * @return int
     */
    public function getExpLevel()
    {
        return $this->expLevel;
    }

    /**
     * Set trophies.
     *
     * @param int|null $trophies
     *
     * @return CRInfo
     */
    public function setTrophies($trophies = null)
    {
        $this->trophies = $trophies;

        return $this;
    }

    /**
     * Get trophies.
     *
     * @return int|null
     */
    public function getTrophies()
    {
        return $this->trophies;
    }

    /**
     * Set donations.
     *
     * @param int|null $donations
     *
     * @return CRInfo
     */
    public function setDonations($donations = null)
    {
        $this->donations = $donations;

        return $this;
    }

    /**
     * Get donations.
     *
     * @return int|null
     */
    public function getDonations()
    {
        return $this->donations;
    }

    /**
     * Set donationsReceived.
     *
     * @param int|null $donationsReceived
     *
     * @return CRInfo
     */
    public function setDonationsReceived($donationsReceived = null)
    {
        $this->donationsReceived = $donationsReceived;

        return $this;
    }

    /**
     * Get donationsReceived.
     *
     * @return int|null
     */
    public function getDonationsReceived()
    {
        return $this->donationsReceived;
    }

    /**
     * Set donationsPercent.
     *
     * @param float|null $donationsPercent
     *
     * @return CRInfo
     */
    public function setDonationsPercent($donationsPercent = null)
    {
        $this->donationsPercent = $donationsPercent;

        return $this;
    }

    /**
     * Get donationsPercent.
     *
     * @return float|null
     */
    public function getDonationsPercent()
    {
        return $this->donationsPercent;
    }

    /**
     * Set arenaName.
     *
     * @param string|null $arenaName
     *
     * @return CRInfo
     */
    public function setArenaName($arenaName = null)
    {
        $this->arenaName = $arenaName;

        return $this;
    }

    /**
     * Get arenaName.
     *
     * @return string|null
     */
    public function getArenaName()
    {
        return $this->arenaName;
    }
}
