<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/12/14
 * Time: 3:02 PM
 */

namespace Campaign\Entity;


abstract class AbstractRewards {

    public abstract function init();

    private $unique_id;

    private $campaign_id;

    private $reward_id;

    /**
     * @param mixed $campaign_id
     */
    public function setCampaignId($campaign_id)
    {
        $this->campaign_id = $campaign_id;
    }

    /**
     * @return mixed
     */
    public function getCampaignId()
    {
        return $this->campaign_id;
    }

    /**
     * @param mixed $unique_id
     */
    public function setUniqueId($unique_id)
    {
        $this->unique_id = $unique_id;
    }

    /**
     * @return mixed
     */
    public function getUniqueId()
    {
        return $this->unique_id;
    }

    /**
     * @param mixed $reward_id
     */
    public function setRewardId($reward_id)
    {
        $this->reward_id = $reward_id;
    }

    /**
     * @return mixed
     */
    public function getRewardId()
    {
        return $this->reward_id;
    }

} 