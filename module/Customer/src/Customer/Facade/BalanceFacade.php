<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/16/14
 * Time: 2:47 PM
 */

namespace Customer\Facade;


class BalanceFacade {

    /**
     * @param $balanceObject
     * @return array
     */
    public function formatBalance($balanceObject)
    {
        if(isset($balanceObject['campaign']['customer']['items']))
        {
            $items = $balanceObject['campaign']['customer']['items'];
        }
        else
        {
            $balance = $balanceObject['campaign']['customer']['balance'];
        }

        if($balance['balance'] != 0)
        {
            $canRedeem = true;
        }
        else
        {
            if(($balanceObject['campaign']['campaign_type'] == "buyx") && (self::getSumItemsBalance($items) != 0))
            {
                $canRedeem = true;
            }
            else
            {
                $canRedeem = false;
            }
        }

        return array(
            "campaignId" => $balanceObject['campaign']['campaign_id'],
            "campaignName" => $balanceObject['campaign']['campaign_name'],
            "balance" => $balance,
            "items" => $items,
            "canRedeem" => $canRedeem,
            "campaignType" => $balanceObject['campaign']['campaign_type']
        );
    }

    /**
     * @param $balanceCollection
     * @return array
     */
    public function formatBalanceCollection($balanceCollection)
    {
        foreach($balanceCollection as $balanceObject)
        {
            $balance = self::formatBalance($balanceObject);
            $balances[] = $balance;
        }

        return $balances;
    }

    /**
     * @param $items
     * @return int
     */
    private function getSumItemsBalance($items)
    {
        $sum = 0;
        foreach($items as $item)
        {
            $sum += $item['balance'];
        }
        return $sum;
    }
} 