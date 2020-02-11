<?php

namespace Application\UserBundle\Entity;

use Application\ClanBundle\Entity\BattleDeck;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 *
 *
 * @ORM\Table(name="CR__User_CRStat")
 * @ORM\Entity(repositoryClass="CRStatRepository")
 * @Serializer\ExclusionPolicy("all")
 * @Gedmo\Loggable
 */
class CRStat extends BaseEntity
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
    private $tournamentCardsWon;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $maxTrophies;


    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $threeCrownWins;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $cardsFound;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $totalDonations;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $challengeMaxWins;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $challengeCardsWon;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $clanCardsCollected;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $total;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $tournamentGames;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $wins;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $warDayWins;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $losses;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $draws;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     *
     * @Serializer\Expose
     */
    private $winsPercent;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     *
     * @Serializer\Expose
     */
    private $lossesPercent;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     *
     * @Serializer\Expose
     */
    private $drawsPercent;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     *
     * @Serializer\Expose
     */
    private $bronzePercent;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     *
     * @Serializer\Expose
     */
    private $silverPercent;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     *
     * @Serializer\Expose
     */
    private $goldPercent;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     *
     * @Serializer\Expose
     */
    private $LegendaryPercent;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     *
     * @Serializer\Expose
     */
    private $maxCardsPercent;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     *
     * @Serializer\Expose
     */
    private $overallScore;


    /**
     * BattleDeck
     *
     * @ORM\ManyToOne(targetEntity="Application\ClanBundle\Entity\BattleDeck")
     * @ORM\JoinColumn(referencedColumnName="id",nullable=true, onDelete="SET NULL")
     *
     * @Serializer\Expose
     *
     */
    private $battleDeck;


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
     * Set tournamentCardsWon.
     *
     * @param int|null $tournamentCardsWon
     *
     * @return CRStat
     */
    public function setTournamentCardsWon($tournamentCardsWon = null)
    {
        $this->tournamentCardsWon = $tournamentCardsWon;

        return $this;
    }

    /**
     * Get tournamentCardsWon.
     *
     * @return int|null
     */
    public function getTournamentCardsWon()
    {
        return $this->tournamentCardsWon;
    }

    /**
     * Set maxTrophies.
     *
     * @param int|null $maxTrophies
     *
     * @return CRStat
     */
    public function setMaxTrophies($maxTrophies = null)
    {
        $this->maxTrophies = $maxTrophies;

        return $this;
    }

    /**
     * Get maxTrophies.
     *
     * @return int|null
     */
    public function getMaxTrophies()
    {
        return $this->maxTrophies;
    }

    /**
     * Set threeCrownWins.
     *
     * @param int|null $threeCrownWins
     *
     * @return CRStat
     */
    public function setThreeCrownWins($threeCrownWins = null)
    {
        $this->threeCrownWins = $threeCrownWins;

        return $this;
    }

    /**
     * Get threeCrownWins.
     *
     * @return int|null
     */
    public function getThreeCrownWins()
    {
        return $this->threeCrownWins;
    }

    /**
     * Set cardsFound.
     *
     * @param int|null $cardsFound
     *
     * @return CRStat
     */
    public function setCardsFound($cardsFound = null)
    {
        $this->cardsFound = $cardsFound;

        return $this;
    }

    /**
     * Get cardsFound.
     *
     * @return int|null
     */
    public function getCardsFound()
    {
        return $this->cardsFound;
    }

    /**
     * Set totalDonations.
     *
     * @param int|null $totalDonations
     *
     * @return CRStat
     */
    public function setTotalDonations($totalDonations = null)
    {
        $this->totalDonations = $totalDonations;

        return $this;
    }

    /**
     * Get totalDonations.
     *
     * @return int|null
     */
    public function getTotalDonations()
    {
        return $this->totalDonations;
    }

    /**
     * Set challengeMaxWins.
     *
     * @param int|null $challengeMaxWins
     *
     * @return CRStat
     */
    public function setChallengeMaxWins($challengeMaxWins = null)
    {
        $this->challengeMaxWins = $challengeMaxWins;

        return $this;
    }

    /**
     * Get challengeMaxWins.
     *
     * @return int|null
     */
    public function getChallengeMaxWins()
    {
        return $this->challengeMaxWins;
    }

    /**
     * Set challengeCardsWon.
     *
     * @param int|null $challengeCardsWon
     *
     * @return CRStat
     */
    public function setChallengeCardsWon($challengeCardsWon = null)
    {
        $this->challengeCardsWon = $challengeCardsWon;

        return $this;
    }

    /**
     * Get challengeCardsWon.
     *
     * @return int|null
     */
    public function getChallengeCardsWon()
    {
        return $this->challengeCardsWon;
    }

    /**
     * Set battleDeck.
     *
     * @param BattleDeck|null $battleDeck
     *
     * @return CRStat
     */
    public function setBattleDeck(BattleDeck $battleDeck = null)
    {
        $this->battleDeck = $battleDeck;

        return $this;
    }

    /**
     * Get battleDeck.
     *
     * @return BattleDeck|null
     */
    public function getBattleDeck()
    {
        return $this->battleDeck;
    }

    /**
     * Set clanCardsCollected.
     *
     * @param int|null $clanCardsCollected
     *
     * @return CRStat
     */
    public function setClanCardsCollected($clanCardsCollected = null)
    {
        $this->clanCardsCollected = $clanCardsCollected;

        return $this;
    }

    /**
     * Get clanCardsCollected.
     *
     * @return int|null
     */
    public function getClanCardsCollected()
    {
        return $this->clanCardsCollected;
    }

    /**
     * Set total.
     *
     * @param int|null $total
     *
     * @return CRStat
     */
    public function setTotal($total = null)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total.
     *
     * @return int|null
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set tournamentGames.
     *
     * @param int|null $tournamentGames
     *
     * @return CRStat
     */
    public function setTournamentGames($tournamentGames = null)
    {
        $this->tournamentGames = $tournamentGames;

        return $this;
    }

    /**
     * Get tournamentGames.
     *
     * @return int|null
     */
    public function getTournamentGames()
    {
        return $this->tournamentGames;
    }

    /**
     * Set wins.
     *
     * @param int|null $wins
     *
     * @return CRStat
     */
    public function setWins($wins = null)
    {
        $this->wins = $wins;

        return $this;
    }

    /**
     * Get wins.
     *
     * @return int|null
     */
    public function getWins()
    {
        return $this->wins;
    }

    /**
     * Set warDayWins.
     *
     * @param int|null $warDayWins
     *
     * @return CRStat
     */
    public function setWarDayWins($warDayWins = null)
    {
        $this->warDayWins = $warDayWins;

        return $this;
    }

    /**
     * Get warDayWins.
     *
     * @return int|null
     */
    public function getWarDayWins()
    {
        return $this->warDayWins;
    }

    /**
     * Set losses.
     *
     * @param int|null $losses
     *
     * @return CRStat
     */
    public function setLosses($losses = null)
    {
        $this->losses = $losses;

        return $this;
    }

    /**
     * Get losses.
     *
     * @return int|null
     */
    public function getLosses()
    {
        return $this->losses;
    }

    /**
     * Set draws.
     *
     * @param int|null $draws
     *
     * @return CRStat
     */
    public function setDraws($draws = null)
    {
        $this->draws = $draws;

        return $this;
    }

    /**
     * Get draws.
     *
     * @return int|null
     */
    public function getDraws()
    {
        return $this->draws;
    }

    /**
     * Set winsPercent.
     *
     * @param float|null $winsPercent
     *
     * @return CRStat
     */
    public function setWinsPercent($winsPercent = null)
    {
        $this->winsPercent = $winsPercent;

        return $this;
    }

    /**
     * Get winsPercent.
     *
     * @return float|null
     */
    public function getWinsPercent()
    {
        return $this->winsPercent;
    }

    /**
     * Set lossesPercent.
     *
     * @param float|null $lossesPercent
     *
     * @return CRStat
     */
    public function setLossesPercent($lossesPercent = null)
    {
        $this->lossesPercent = $lossesPercent;

        return $this;
    }

    /**
     * Get lossesPercent.
     *
     * @return float|null
     */
    public function getLossesPercent()
    {
        return $this->lossesPercent;
    }

    /**
     * Set drawsPercent.
     *
     * @param float|null $drawsPercent
     *
     * @return CRStat
     */
    public function setDrawsPercent($drawsPercent = null)
    {
        $this->drawsPercent = $drawsPercent;

        return $this;
    }

    /**
     * Get drawsPercent.
     *
     * @return float|null
     */
    public function getDrawsPercent()
    {
        return $this->drawsPercent;
    }


    /**
     * Set bronzePercent.
     *
     * @param float|null $bronzePercent
     *
     * @return CRStat
     */
    public function setBronzePercent($bronzePercent = null)
    {
        $this->bronzePercent = $bronzePercent;

        return $this;
    }

    /**
     * Get bronzePercent.
     *
     * @return float|null
     */
    public function getBronzePercent()
    {
        return $this->bronzePercent;
    }

    /**
     * Set silverPercent.
     *
     * @param float|null $silverPercent
     *
     * @return CRStat
     */
    public function setSilverPercent($silverPercent = null)
    {
        $this->silverPercent = $silverPercent;

        return $this;
    }

    /**
     * Get silverPercent.
     *
     * @return float|null
     */
    public function getSilverPercent()
    {
        return $this->silverPercent;
    }

    /**
     * Set goldPercent.
     *
     * @param float|null $goldPercent
     *
     * @return CRStat
     */
    public function setGoldPercent($goldPercent = null)
    {
        $this->goldPercent = $goldPercent;

        return $this;
    }

    /**
     * Get goldPercent.
     *
     * @return float|null
     */
    public function getGoldPercent()
    {
        return $this->goldPercent;
    }

    /**
     * Set legendaryPercent.
     *
     * @param float|null $legendaryPercent
     *
     * @return CRStat
     */
    public function setLegendaryPercent($legendaryPercent = null)
    {
        $this->LegendaryPercent = $legendaryPercent;

        return $this;
    }

    /**
     * Get legendaryPercent.
     *
     * @return float|null
     */
    public function getLegendaryPercent()
    {
        return $this->LegendaryPercent;
    }

    public function setAllCardStats(User $user)
    {
        $bronze    = $user->getOverallCardsPercentage('bronze');
        $silver    = $user->getOverallCardsPercentage('silver');
        $gold      = $user->getOverallCardsPercentage('gold');
        $legendary = $user->getOverallCardsPercentage('legendary');
        $max       = $user->getOverallCardsPercentage('lvl13');

        //max Score = 108 + 50 + 25 + 12 + 5 = 200
        $overall = ($max * 1.08) + (0.5 * $legendary) + (0.25 * $gold) + (0.12 * $silver) + (0.05 * $bronze);

        $this->setBronzePercent($bronze);
        $this->setSilverPercent($silver);
        $this->setGoldPercent($gold);
        $this->setLegendaryPercent($legendary);
        $this->setMaxCardsPercent($max);
        $this->setOverallScore(round($overall, 2));
    }

    /**
     * Set overallScore.
     *
     * @param float|null $overallScore
     *
     * @return CRStat
     */
    public function setOverallScore($overallScore = null)
    {
        $this->overallScore = $overallScore;

        return $this;
    }

    /**
     * Get overallScore.
     *
     * @return float|null
     */
    public function getOverallScore()
    {
        return $this->overallScore;
    }

    /**
     * Set maxCardsPercent.
     *
     * @param float|null $maxCardsPercent
     *
     * @return CRStat
     */
    public function setMaxCardsPercent($maxCardsPercent = null)
    {
        $this->maxCardsPercent = $maxCardsPercent;

        return $this;
    }

    /**
     * Get maxCardsPercent.
     *
     * @return float|null
     */
    public function getMaxCardsPercent()
    {
        return $this->maxCardsPercent;
    }
}
