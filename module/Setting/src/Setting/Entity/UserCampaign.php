<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/6/14
 * Time: 8:49 AM
 */

namespace Setting\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="lp_user_campaigns")
 * @ORM\Entity
 */
class UserCampaign {

    /**
     * @var integer
     *
     * @ORM\Column(name="campaign_id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $campaign_id;

    /**
     * @var string
     * @ORM\Column(name="campaign_name", type="string", nullable=false)
     */
    private $campaign_name;

    /**
     * @var string
     * @ORM\Column(name="account_id", type="string", nullable=false)
     */
    private $account_id;

    /**
     * @return string
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * @param string $account_id
     */
    public function setAccountId($account_id)
    {
        $this->account_id = $account_id;
    }

    /**
     * @return int
     */
    public function getCampaignId()
    {
        return $this->campaign_id;
    }

    /**
     * @param int $campaign_id
     */
    public function setCampaignId($campaign_id)
    {
        $this->campaign_id = $campaign_id;
    }

    /**
     * @return string
     */
    public function getCampaignName()
    {
        return $this->campaign_name;
    }

    /**
     * @param string $campaign_name
     */
    public function setCampaignName($campaign_name)
    {
        $this->campaign_name = $campaign_name;
    }

} 