<?php

namespace Campaign\Entity\Promotion;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table(name="points_multipliers")
 * @ORM\Entity
 */
class Promotion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="unique_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(name="campaign_id", type="string", nullable=true)
     * @var string
     */
    private $campaign_id;

    /**
     * @ORM\Column(name="multiplier", type="float", nullable=true)
     * @var float
     */
    private $multiplier;

    /**
     * @ORM\Column(name="operation", type="string", nullable=true)
     * @var string
     */
    private $operation;

    /**
     * @ORM\Column(name="promotion", type="string", nullable=true)
     * @var string
     */
    private $promotion;

    /**
     * @ORM\Column(name="promo_custom_id", type="string", nullable=true)
     * @var string
     */
    private $promo_custom_id;

    /**
     * @ORM\Column(name="promo_start_date", type="string", nullable=true)
     * @var string
     */
    private $promo_start_date;

    /**
     * @ORM\Column(name="promo_end_date", type="string", nullable=true)
     * @var string
     */
    private $promo_end_date;

    /**
     * @param string $campaign_id
     */
    public function setCampaignId($campaign_id)
    {
        $this->campaign_id = $campaign_id;
    }

    /**
     * @return string
     */
    public function getCampaignId()
    {
        return $this->campaign_id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param float $multiplier
     */
    public function setMultiplier($multiplier)
    {
        $this->multiplier = $multiplier;
    }

    /**
     * @return float
     */
    public function getMultiplier()
    {
        return $this->multiplier;
    }

    /**
     * @param string $operation
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param string $promo_custom_id
     */
    public function setPromoCustomId($promo_custom_id)
    {
        $this->promo_custom_id = $promo_custom_id;
    }

    /**
     * @return string
     */
    public function getPromoCustomId()
    {
        return $this->promo_custom_id;
    }

    /**
     * @param string $promo_end_date
     */
    public function setPromoEndDate($promo_end_date)
    {
        $this->promo_end_date = $promo_end_date;
    }

    /**
     * @return string
     */
    public function getPromoEndDate()
    {
        return $this->promo_end_date;
    }

    /**
     * @param string $promo_start_date
     */
    public function setPromoStartDate($promo_start_date)
    {
        $this->promo_start_date = $promo_start_date;
    }

    /**
     * @return string
     */
    public function getPromoStartDate()
    {
        return $this->promo_start_date;
    }

    /**
     * @param string $promotion
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * @return string
     */
    public function getPromotion()
    {
        return $this->promotion;
    }


} 