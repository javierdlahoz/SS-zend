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
    const ADD_CUSTOMER_TYPE = "record_customer";
    const ADD_CUSTOMER_ACTION = "new";

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

    /**
     * @param array|Customer $customer
     *
     * @throws \Exception
     * @return bool
     */
    public function add(array $customer)
    {

        $this->prepareParams();
        unset($this->params['code']);
        unset($this->params['campaign_id']);
        unset($this->params['authorization']);

        $this->params['type'] = self::ADD_CUSTOMER_TYPE;
        $this->params['action'] = self::ADD_CUSTOMER_ACTION;

        foreach($customer as $key => $value)
        {
            $this->params[$key] = $value;
        }


        return $this->sendRequest($this->params, true);
    }
} 