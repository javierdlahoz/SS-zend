<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/4/14
 * Time: 3:18 PM
 */

namespace Campaign\Service;

use Application\Service\AbstractService;
use Campaign\Facade\Reward\VisitRewardFacade;
use Campaign\Facade\Reward\PointRewardFacade;

class CampaignService extends AbstractService
{
    const POINTS = "T";
    const VISITS = "V";
    const DOLLARS = "D";
    const BUYX = "S";
    const GIFTCARDS = "G";

    const BUYX_REWARDS = "buyXget1free_rewards";
    const VISITS_REWARDS = "visits_rewards";
    const POINTS_REWARDS = "accumulated_dollars_rewards";

    /**
     * @param $accountId
     * @return \Application\Service\mysqli_result
     */
    public function getActiveCampaigns($accountId)
    {
        $fields = "campaigns.campaign_id, campaigns.campaign_name";
        $entities = "account_campaigns INNER JOIN campaigns";
        $query = "ON account_campaigns.campaign_id = campaigns.campaign_id WHERE account_campaigns.account_id = '{$accountId}'";

        return $this->select($fields, $query, $entities);
    }

    /**
     * @param $accountId
     * @param $campaignId
     * @return \Application\Service\mysqli_result
     */
    private function getDailyVolumePerCampaign($accountId, $campaignId)
    {
        $this->setEntity(self::VISIT.$accountId);
        $fields = "COUNT(*) as count, SUM(amount) as sum, date";
        $query = "WHERE amount >= 0 AND campaign_id = '{$campaignId}' GROUP BY date";

        return $this->select($fields, $query);
    }

    /**
     * @param $accountId
     * @return array
     */
    public function getDailyVolumeAllCampaigns($accountId)
    {
        $campaigns = $this->getActiveCampaigns($accountId);
        foreach($campaigns as $campaign)
        {
            $dailyVolumePerCampaign = $this->getDailyVolumesTotals($this->getDailyVolumePerCampaign($accountId, $campaign['campaign_id']));
            $dailyVolumes[] = array(
                "campaignId" => $campaign['campaign_id'],
                "campaignName" => $campaign['campaign_name'],
                "transactionPerDay" => $dailyVolumePerCampaign['transactionPerDay'],
                "valuePerDay" => $dailyVolumePerCampaign['valuePerDay']
            );
        }

        return $dailyVolumes;
    }

    /**
     * @param $dailyVolumePerCampaign
     * @return array
     */
    private function getDailyVolumesTotals($dailyVolumePerCampaign)
    {
        $valuePerDay = 0;
        $transactionPerDay = 0;
        $daysSize = count($dailyVolumePerCampaign);
        $count = 0;

        foreach($dailyVolumePerCampaign as $dailyVolume)
        {
            if($count == 0)
            {
                $startDate = $dailyVolume['date'];
            }
            elseif($count == $daysSize - 1)
            {
                $endDate = $dailyVolume['date'];
            }
            $count++;

            $valuePerDay += $dailyVolume['sum'];
            $transactionPerDay += $dailyVolume['count'];
        }

        $days = $this->select("DATEDIFF('{$endDate}', '{$startDate}')", "LIMIT 1");
        $days = $days[0][0] + 1;

        if($days == 0)
        {
            $valuePerDay = 0;
            $transactionPerDay = 0;
        }
        else
        {
            $valuePerDay = number_format($valuePerDay/$days, 0);
            $transactionPerDay = number_format($transactionPerDay/$days, 0);
        }

        return array(
            "valuePerDay" => $valuePerDay,
            "transactionPerDay" => $transactionPerDay
        );
    }

    /**
     * @param $campaignId
     * @return \Application\Service\mysqli_result
     */
    public function getType($campaignId)
    {
        $fields = "campaign_type";
        $entities = "campaigns";
        $query = " WHERE campaign_id = '{$campaignId}'";

        $type = $this->select($fields, $query, $entities);
        $type = $type[0]['campaign_type'];

        return $type;
    }

    /**
     * @param $campaignId
     * @return mixed
     */
    public function getPromotions($campaignId)
    {
        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $promotions = $entityManager->getRepository('Campaign\Entity\Promotion\Promotion')->findBy(array('campaign_id' => $campaignId));

        return $promotions;
    }

    /**
     * @param $campaignId
     * @return array
     */
    public function getRewards($campaignId)
    {
        $type = $this->getType($campaignId);

        switch($type)
        {
            case self::VISITS:
                return VisitRewardFacade::formatRewardCollection($this->getVisitRewards($campaignId));
                break;

            case self::POINTS:
                return PointRewardFacade::formatRewardCollection($this->getPointRewards($campaignId));
                break;
        }

    }

    /**
     * @param $campaignId
     * @return \Application\Service\mysqli_result
     */
    private function getVisitRewards($campaignId)
    {
        $entity = self::VISITS_REWARDS;
        $fields = "*";
        $query = " WHERE campaign_id = '{$campaignId}'";

        $rewards = $this->select($fields, $query, $entity);
        return $rewards;
    }

    /**
     * @param $campaignId
     * @return \Application\Service\mysqli_result
     */
    private function getPointRewards($campaignId)
    {
        $entity = self::POINTS_REWARDS;
        $fields = "*";
        $query = " WHERE campaign_id = '{$campaignId}'";

        $rewards = $this->select($fields, $query, $entity);
        return $rewards;
    }

    /**
     * @param $campaignId
     * @return \Application\Service\mysqli_result
     */
    public function getBuyXRewards($campaignId)
    {
        $entity = self::BUYX_REWARDS;
        $fields = "*";
        $query = " WHERE campaign_id = '{$campaignId}' AND service_product != 'default'";

        return $this->select($fields, $query, $entity);
    }
}