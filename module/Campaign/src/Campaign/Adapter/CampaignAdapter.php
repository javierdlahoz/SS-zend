<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/19/14
 * Time: 10:30 AM
 */

namespace Campaign\Adapter;

use Application\Adapter\StickyStreetAdapter;
use Campaign\Facade\Item\ItemFacace;

class CampaignAdapter extends StickyStreetAdapter{

    const BUYX_ITEMS = "campaign_promos";

    /**
     * @param $campaignId
     */
    public function prepareParams($campaignId)
    {
        $apiCredentials = $this->getServiceLocator()->get('userHelper')->getApiCredentials($this->user);

        $this->setParams(array(
            'user_id' => $this->user->getUsername(),
            'user_api_key' => $apiCredentials['token'],
            'API' => self::API_VERSION,
            'account_id' => $apiCredentials['accountId'],
            'campaign_id' => $campaignId,
            'output' => "JSON"
        ));
    }

    /**
     * @param $campaignId
     * @return array
     */
    public function getBuyXItems($campaignId)
    {
        $this->prepareParams($campaignId);
        $this->params['type'] = self::BUYX_ITEMS;

        var_dump($this->params);
        $items = $this->sendRequest(null, true);

        return ItemFacace::formatItemCollection($items['buyx_items']);
    }
} 