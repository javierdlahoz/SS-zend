<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/16/14
 * Time: 2:47 PM
 */

namespace Customer\Facade;


class BalanceFacade {

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

        return array(
            "campaignId" => $balanceObject['campaign']['campaign_id'],
            "campaignName" => $balanceObject['campaign']['campaign_name'],
            "balance" => $balance,
            "items" => $items,
            "campaignType" => $balanceObject['campaign']['campaign_type']
        );
    }

    public function formatBalanceCollection($balanceCollection)
    {
        foreach($balanceCollection as $balanceObject)
        {
            $balance = self::formatBalance($balanceObject);
            if(($balance['balance'] != 0) || ($balance['items'] != null))
            {
                $balances[] = $balance;
            }
        }

        return $balances;
    }
} 