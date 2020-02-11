<?php

namespace Application\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\MappedSuperclass
 * @Serializer\ExclusionPolicy("all")
 */
abstract class BaseEntity
{
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     *
     * @Serializer\Expose
     * @Serializer\Type("DateTime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     *
     * @Serializer\Expose
     * @Serializer\Type("DateTime")
     */
    protected $updatedAt;

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return self
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->createdAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param $number
     * @param int $precision
     * @param bool $floor
     * @return int|string
     */
    public function getNumberShort($number, $precision = 1, $floor = true)
    {
        $n = $number + 0;

        if ($n < 1000) {
            $n_format = $n;
        } elseif ($n < 1000000) {
            // Anything less than a million
            $n = $n / 1000;
            if ($floor) {
                $n = floor($n * 10) / 10;
            }

            $n_format = (number_format($n, $precision) + 0) . ' k';
        } elseif ($n < 1000000000) {
            // Anything less than a billion
            $n = $n / 1000000;
            if ($floor) {
                $n = floor($n * 10) / 10;
            }

            $n_format = number_format($n, $precision) + 0 . ' m';
        } else {
            // At least a billion
            $n = $n / 1000000000;
            if ($floor) {
                $n = floor($n * 10) / 10;
            }

            $n_format = number_format($n, $precision) + 0 . ' b';
        }

        return $n_format;
    }
}
