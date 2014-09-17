<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/16/14
 * Time: 11:59 AM
 */

namespace Customer\Adapter;

use Application\Adapter\StickyStreetAdapter;

class CustomerAdapter extends StickyStreetAdapter
{
    const BALANCE = "customer_balance";

    /**
     * @param $customerCode
     * @param $campaignId
     * @return bool
     */
    public function getBalance($customerCode, $campaignId)
    {
        $this->prepareParams($customerCode, $campaignId);
        $this->params['type'] = self::BALANCE;

        return $this->sendRequest(null, true);

    }
} 