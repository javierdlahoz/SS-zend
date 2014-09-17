<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/4/14
 * Time: 3:18 PM
 */

namespace Campaign\Service;

use Application\Service\AbstractService;

class CampaignService extends AbstractService
{
    const POINTS = "T";
    const VISITS = "V";
    const DOLLARS = "D";
    const BUYX = "S";
    const GIFTCARDS = "G";

    public function getActiveCampaigns($accountId)
    {
        $fields = "campaigns.campaign_id, campaigns.campaign_name";
        $entities = "account_campaigns INNER JOIN campaigns";
        $query = "ON account_campaigns.campaign_id = campaigns.campaign_id WHERE account_campaigns.account_id = '{$accountId}'";

        return $this->select($fields, $query, $entities);
    }

    private function getDailyVolumePerCampaign($accountId, $campaignId)
    {
        $this->setEntity(self::VISIT.$accountId);
        $fields = "COUNT(*) as count, SUM(amount) as sum, date";
        $query = "WHERE amount >= 0 AND campaign_id = '{$campaignId}' GROUP BY date";

        return $this->select($fields, $query);
    }

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

    public function getType($campaignId)
    {
        $fields = "campaign_type";
        $entities = "campaigns";
        $query = " WHERE campaign_id = '{$campaignId}'";

        $type = $this->select($fields, $query, $entities);
        $type = $type[0]['campaign_type'];

        return $type;
    }

    public function getPromotions($campaignId)
    {
        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $promotions = $entityManager->getRepository('Campaign\Entity\Promotion\Promotion')->findBy(array('campaign_id' => $campaignId));

        return $promotions;
    }

}