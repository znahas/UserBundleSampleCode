<?php

namespace Application\UserBundle\Entity;

use Application\ClanBundle\Entity\Battle;
use Application\ClanBundle\Entity\Card;
use Application\ClanBundle\Entity\ClanMember;
use Application\ClanBundle\Entity\ClanWarMember;
use Application\ClanBundle\Entity\UserCard;
use Application\ClanBundle\Entity\UserDeck;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Application\ClanBundle\Entity\Clan;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="UserRepository")
 * @ORM\Table(name="CR__User",
 *      indexes={@ORM\Index(columns={"tag"}),@ORM\Index(columns={"deletedAt"})}
 * )
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @UniqueEntity("email")
 *
 * @Serializer\ExclusionPolicy("all")
 * @Gedmo\Loggable
 *
 */
class User extends BaseUser
{

    const ROLE_CLAN = 'ROLE_CLAN';
    const ROLE_CLAN_ADMIN = 'ROLE_CLAN_ADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=40, nullable=true)
     *
     * @Serializer\Expose
     * @Gedmo\Versioned
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Serializer\Expose
     * @Gedmo\Versioned
     */
    protected $lastname;

    /**
     * @Gedmo\Slug(fields={"firstname"})
     * @ORM\Column()
     * @Gedmo\Versioned
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10, unique=true)
     * @Gedmo\Versioned
     * @Serializer\Expose
     */
    private $tag;

    /**
     * @var boolean
     *
     * @ORM\Column(name="notify", type="boolean", nullable=true)
     *
     * @Serializer\Expose
     * @Gedmo\Versioned
     */
    protected $notify;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Serializer\Expose
     * @Gedmo\Versioned
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=8)
     *
     * @Serializer\Expose
     * @Gedmo\Versioned
     */
    protected $language = "en";

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     *
     * @Serializer\Expose
     * @Gedmo\Versioned
     */
    protected $timezone = "Asia/Dubai";


    /**
     * @ORM\ManyToOne(targetEntity="Application\ClanBundle\Entity\Clan", inversedBy="users")
     * @ORM\JoinColumn(referencedColumnName="id")
     *
     * @Serializer\Expose
     * @Gedmo\Versioned
     */
    protected $clan;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     *
     * @Serializer\Expose
     * @Gedmo\Versioned
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Serializer\Expose
     * @Gedmo\Versioned
     */
    protected $deletedAt;


    /**
     * @ Assert\Regex(
     *     pattern="/^[A-Za-z]+(?:[_-][A-Za-z0-9]+)*$/",
     *     match=true,
     *     message="Illegal characters in tag (allowed: 0289CGJLPQRUVY)"
     * )
     * @Gedmo\Versioned
     */
    protected $username;

    /**
     * @Gedmo\Versioned
     */
    protected $email;

    /**
     * @Gedmo\Versioned
     */
    protected $enabled;

    /**
     * @Gedmo\Versioned
     */
    protected $passwordRequestedAt;

    /**
     * @Gedmo\Versioned
     */
    protected $locked;

    /**
     * @Gedmo\Versioned
     */
    protected $expired;

    /**
     * @Gedmo\Versioned
     */
    protected $expiresAt;

    /**
     * @Gedmo\Versioned
     */
    protected $roles;

    /**
     * @Gedmo\Versioned
     */
    protected $credentialsExpired;

    /**
     * @Gedmo\Versioned
     */
    protected $credentialsExpireAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="password_changed_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $password_changed_at;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isBanned = false;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $leftClan = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastImported;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isTracked = false;

    /**
     * @var CRInfo
     *
     * @ORM\OneToOne(targetEntity="Application\UserBundle\Entity\CRInfo",cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="cr_id", referencedColumnName="id")
     */
    protected $crInfo;

    /**
     * @var CRStat
     *
     * @ORM\OneToOne(targetEntity="Application\UserBundle\Entity\CRStat",cascade={"persist"})
     * @ORM\JoinColumn(name="stat_id", referencedColumnName="id")
     */
    protected $crStat;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\ClanBundle\Entity\Battle", mappedBy="user")
     */
    protected $battles;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\ClanBundle\Entity\Battle", mappedBy="opponentUser")
     */
    protected $battlesAgainst;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\ClanBundle\Entity\ClanMember", mappedBy="user")
     */
    protected $members;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\ClanBundle\Entity\ClanWarMember", mappedBy="user")
     */
    protected $wars;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\ClanBundle\Entity\UserCard", mappedBy="user")
     */
    protected $userCards;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\ClanBundle\Entity\UserDeck", mappedBy="user")
     */
    protected $userDecks;

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
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set notify
     *
     * @param boolean $notify
     * @return User
     */
    public function setNotify($notify)
    {
        $this->notify = $notify;

        return $this;
    }

    /**
     * Get notify
     *
     * @return boolean
     */
    public function getNotify()
    {
        return $this->notify;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return User
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    public function getLocale()
    {
        return $this->getLanguage();
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     * @return User
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return User
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->getFirstname() . " " . $this->getLastname();
    }

    public function __toString()
    {
        return $this->getFirstname();
    }


    /**
     * Set clan
     *
     * @param Clan $clan
     * @return User
     */
    public function setClan(Clan $clan = null)
    {
        $this->clan = $clan;

        return $this;
    }

    /**
     * Get clan
     *
     * @param bool $memberclan
     * @return Clan
     */
    public function getClan($memberclan = true)
    {
        if ($memberclan && $this->id) {

            /** @var ClanMember $clanMember */
            $clanMember = $this->getMembers(true)->first();

            if ($clanMember) {
                return $clanMember->getClan();
            }
        }

        return $this->clan;
    }


    /**
     * Set password_changed_at
     *
     * @param \DateTime $passwordChangedAt
     * @return User
     */
    public function setPasswordChangedAt(\DateTime $passwordChangedAt)
    {
        $this->password_changed_at = $passwordChangedAt;

        return $this;
    }

    /**
     * Get password_changed_at
     *
     * @return \DateTime
     */
    public function getPasswordChangedAt()
    {
        return $this->password_changed_at;
    }

    /**
     * @param $password
     * @return BaseUser|void
     * @throws \Exception
     */
    public function setPlainPassword($password)
    {
        $today = new \DateTime();
        $this->setPasswordChangedAt($today);
        parent::setPlainPassword($password);
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Set tag.
     *
     * @param string $tag
     *
     * @return User
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag.
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set crInfo.
     *
     * @param CRInfo|null $crInfo
     *
     * @return User
     */
    public function setCrInfo(CRInfo $crInfo = null)
    {
        $this->crInfo = $crInfo;

        return $this;
    }

    /**
     * Get crInfo.
     *
     * @return CRInfo|null
     */
    public function getCrInfo()
    {
        return $this->crInfo;
    }

    /**
     * Add battle.
     *
     * @param Battle $battle
     *
     * @return User
     */
    public function addBattle(Battle $battle)
    {
        $this->battles[] = $battle;

        return $this;
    }

    /**
     * Remove battle.
     *
     * @param Battle $battle
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeBattle(Battle $battle)
    {
        return $this->battles->removeElement($battle);
    }

    /**
     * Get battles.
     *
     * @return Collection
     */
    public function getBattles()
    {
        return $this->battles;
    }

    /**
     * Add battlesAgainst.
     *
     * @param Battle $battlesAgainst
     *
     * @return User
     */
    public function addBattlesAgainst(Battle $battlesAgainst)
    {
        $this->battlesAgainst[] = $battlesAgainst;

        return $this;
    }

    /**
     * Remove battlesAgainst.
     *
     * @param Battle $battlesAgainst
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeBattlesAgainst(Battle $battlesAgainst)
    {
        return $this->battlesAgainst->removeElement($battlesAgainst);
    }

    /**
     * Get battlesAgainst.
     *
     * @return Collection
     */
    public function getBattlesAgainst()
    {
        return $this->battlesAgainst;
    }

    public function isClanAdmin()
    {
        return $this->hasRole(static::ROLE_CLAN_ADMIN);
    }

    public function isAdmin()
    {
        return $this->hasRole(static::ROLE_ADMIN);

    }


    /**
     * Add member.
     *
     * @param ClanMember $member
     *
     * @return User
     */
    public function addMember(ClanMember $member)
    {
        $this->members[] = $member;

        return $this;
    }

    /**
     * Remove member.
     *
     * @param ClanMember $member
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMember(ClanMember $member)
    {
        return $this->members->removeElement($member);
    }

    /**
     * Get members.
     *
     * @param bool $onlyActive
     * @return Collection
     */
    public function getMembers($onlyActive = false)
    {
        return $this->members->filter(
            function (ClanMember $entry) use ($onlyActive) {

                $default = true;

                if ($onlyActive) {
                    $default &= $entry->getIsActive();
                }

                return $default;
            }
        );
    }

    /**
     * @return ClanMember
     */
    public function getActiveMember()
    {
        return $this->getMembers(true)->first();
    }

    /**
     * @param Clan $clan
     * @return ClanMember
     */
    public function getClanMember(Clan $clan)
    {
        return $this->members->filter(
            function (ClanMember $entry) use ($clan) {

                return $entry->getClan() === $clan;
            }
        )->first();
    }


    /**
     * Set isBanned.
     *
     * @param bool|null $isBanned
     *
     * @return User
     */
    public function setIsBanned($isBanned = null)
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    /**
     * Get isBanned.
     *
     * @return bool|null
     */
    public function getIsBanned()
    {
        return $this->isBanned;
    }

    /**
     * Set leftClan.
     *
     * @param bool|null $leftClan
     *
     * @return User
     */
    public function setLeftClan($leftClan = null)
    {
        $this->leftClan = $leftClan;

        return $this;
    }

    /**
     * Get leftClan.
     *
     * @return bool|null
     */
    public function getLeftClan()
    {
        return $this->leftClan;
    }

    /**
     * Add war.
     *
     * @param ClanWarMember $war
     *
     * @return User
     */
    public function addWar(ClanWarMember $war)
    {
        $this->wars[] = $war;

        return $this;
    }

    /**
     * Remove war.
     *
     * @param ClanWarMember $war
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeWar(ClanWarMember $war)
    {
        return $this->wars->removeElement($war);
    }

    /**
     * Get wars.
     *
     * @return Collection
     */
    public function getWars()
    {
        return $this->wars;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return User
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set crStat.
     *
     * @param CRStat|null $crStat
     *
     * @return User
     */
    public function setCrStat(CRStat $crStat = null)
    {
        $this->crStat = $crStat;

        return $this;
    }

    /**
     * Get crStat.
     *
     * @return CRStat|null
     */
    public function getCrStat()
    {
        return $this->crStat;
    }

    /**
     * Add userCard.
     *
     * @param UserCard $userCard
     *
     * @return User
     */
    public function addUserCard(UserCard $userCard)
    {
        $this->userCards[] = $userCard;

        return $this;
    }

    /**
     * Remove userCard.
     *
     * @param UserCard $userCard
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUserCard(UserCard $userCard)
    {
        return $this->userCards->removeElement($userCard);
    }

    /**
     * Get userCards.
     *
     * @param null $cardId
     * @return Collection
     */
    public function getUserCards($cardId = null)
    {
        if ($this->userCards) {
            return $this->userCards->filter(
                function (UserCard $entry) use ($cardId) {

                    $default = true;

                    if ($cardId) {
                        $default &= $entry->getCard()->getId() == $cardId;
                    }

                    return $default;
                }
            );
        }

        return $this->userCards;
    }

    /**
     * @param string $league
     * @return array
     */
    public function getPassCheck($league = 'all')
    {
        $lvl13 = array(
            'lvl13' => array(
                'Common'    => array(
                    'pass'  => 13,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Rare'      => array(
                    'pass'  => 11,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Epic'      => array(
                    'pass'  => 8,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Legendary' => array(
                    'pass'  => 5,
                    'total' => 0,
                    'more'  => 0,
                ),
            )
        );

        $legendary = array(
            'goldplus' => array(
                'Common'    => array(
                    'pass'  => 12,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Rare'      => array(
                    'pass'  => 10,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Epic'      => array(
                    'pass'  => 7,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Legendary' => array(
                    'pass'  => 4,
                    'total' => 0,
                    'more'  => 0,
                ),
            )
        );

        $gold = array(
            'gold' => array(
                'Common'    => array(
                    'pass'  => 11,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Rare'      => array(
                    'pass'  => 9,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Epic'      => array(
                    'pass'  => 6,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Legendary' => array(
                    'pass'  => 3,
                    'total' => 0,
                    'more'  => 0,
                ),
            ),
        );

        $silver = array(
            'silver' => array(
                'Common'    => array(
                    'pass'  => 10,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Rare'      => array(
                    'pass'  => 8,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Epic'      => array(
                    'pass'  => 5,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Legendary' => array(
                    'pass'  => 2,
                    'total' => 0,
                    'more'  => 0,
                ),
            ),
        );

        $bronze = array(
            'bronze' => array(
                'Common'    => array(
                    'pass'  => 9,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Rare'      => array(
                    'pass'  => 7,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Epic'      => array(
                    'pass'  => 4,
                    'total' => 0,
                    'more'  => 0,
                ),
                'Legendary' => array(
                    'pass'  => 1,
                    'total' => 0,
                    'more'  => 0,
                ),
            ),
        );

        $passCheck = array();

        if ($league == 'all') {
            $passCheck = array_merge($legendary, $gold);
        } elseif ($league == 'legendary') {
            $passCheck = array_merge($legendary);
        } elseif ($league == 'lvl13') {
            $passCheck = array_merge($lvl13);
        } elseif ($league == 'gold') {
            $passCheck = array_merge($gold);
        } elseif ($league == 'silver') {
            $passCheck = array_merge($silver);
        } elseif ($league == 'bronze') {
            $passCheck = array_merge($bronze);
        }

        /** @var UserCard[] $userCards */
        $userCards = $this->getUserCards();

        if ($userCards) {

            foreach ($userCards as $userCard) {

                //skip level independent cards
                if (!$userCard->getCard()->getLevelIndependent()) {

                    $rarity = $userCard->getCard()->getCardRarity()->getName();
                    $level  = $userCard->getLevel();

                    foreach ($passCheck as $key => $data) {

                        $passCheck[$key][$rarity]['total']++;

//                        if (($level >= $data[$rarity]['pass']) || $userCard->getCard()->getLevelIndependent()) {
                        if ($level >= $data[$rarity]['pass']) {
                            $passCheck[$key][$rarity]['more']++;
                        }
                    }
                }

            }
        }

        return $passCheck;
    }

    /**
     * @param string $league
     * @return float
     */
    public function getOverallCardsPercentage($league = 'gold')
    {
        $passCheck = $this->getPassCheck($league);

        $overall = 0;

        foreach ($passCheck as $rarities) {
            foreach ($rarities as $rarity) {
                //Avoid division by 0
                if ($rarity['total']) {
                    $overall += $rarity['more'] / $rarity['total'] * 100;
                }
            }
        }

        return round($overall / 4, 2);
    }

    /**
     * Add userDeck.
     *
     * @param UserDeck $userDeck
     *
     * @return User
     */
    public function addUserDeck(UserDeck $userDeck)
    {
        $this->userDecks[] = $userDeck;

        return $this;
    }

    /**
     * Remove userDeck.
     *
     * @param UserDeck $userDeck
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUserDeck(UserDeck $userDeck)
    {
        return $this->userDecks->removeElement($userDeck);
    }

    /**
     * Get userDecks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserDecks()
    {
        return $this->userDecks;
    }

    /**
     * Set lastImported.
     *
     * @param \DateTime|null $lastImported
     *
     * @return User
     */
    public function setLastImported($lastImported = null)
    {
        $this->lastImported = $lastImported;

        return $this;
    }

    /**
     * Get lastImported.
     *
     * @return \DateTime|null
     */
    public function getLastImported()
    {
        return $this->lastImported;
    }

    /**
     * Set isTracked.
     *
     * @param bool|null $isTracked
     *
     * @return User
     */
    public function setIsTracked($isTracked = null)
    {
        $this->isTracked = $isTracked;

        return $this;
    }

    /**
     * Get isTracked.
     *
     * @return bool|null
     */
    public function getIsTracked()
    {
        return $this->isTracked;
    }

    /**
     * @param Card $card
     * @return int|null
     */
    public function getCardStars(Card $card)
    {
        /** @var UserCard $userCard */
        $userCard = $this->getUserCards($card->getId())->first();

        if ($userCard) {
            return $userCard->getStarLevel();
        }

        return null;
    }
}
