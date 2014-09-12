<?php

namespace Campaign\Facade;

class CampaignFacade
{
    public function getCampaignData($campaign)
    {
        return array(
            "id" => $campaign['campaign_id'],
            "name" => $campaign['campaign_name']
        );
    }

    public function formatCampaignList($campaignsSQLResult)
    {
        foreach($campaignsSQLResult as $campaign)
        {
            $campaigns[] = self::getCampaignData($campaign);
        }
        return $campaigns;
    }
}