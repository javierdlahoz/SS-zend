<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/15/14
 * Time: 8:47 AM
 */

namespace Campaign\Entity\Rewards;

use Campaign\Entity\Rewards\AbstractRewards;

/**
 * Customer
 *
 * @ORM\Table(name="dollar_rewards")
 * @ORM\Entity
 */
class EventsReward extends AbstractRewards{

    /**
     * @ORM\Column(name="account_id", type="decimal", nullable=true)
     * @var double
     */
    private $dollar_per_visit;

    /**
     * @ORM\Column(name="account_id", type="decimal", nullable=true)
     * @var double
     */
    private $profit_ratio;

    /**
     * @param float $dollar_per_visit
     */
    public function setDollarPerVisit($dollar_per_visit)
    {
        $this->dollar_per_visit = $dollar_per_visit;
    }

    /**
     * @return float
     */
    public function getDollarPerVisit()
    {
        return $this->dollar_per_visit;
    }

    /**
     * @param float $profit_ratio
     */
    public function setProfitRatio($profit_ratio)
    {
        $this->profit_ratio = $profit_ratio;
    }

    /**
     * @return float
     */
    public function getProfitRatio()
    {
        return $this->profit_ratio;
    }

} 