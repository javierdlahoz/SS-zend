<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/5/14
 * Time: 9:04 AM
 */

namespace Transaction\Facade;

class TransactionFacade
{
    /**
     * @param $customer
     * @return array
     */
    public function getCustomerData($customer)
    {
        return array(
            "name" => $customer['first_name']." ".$customer['last_name'],
            "phone" => $customer['phone'],
            "email" => $customer['email']
        );
    }

    /**
     * @param $lastTransactionsSQLResult
     * @return array
     */
    public function formatLastTransactions($lastTransactionsSQLResult)
    {
        $lastTransactions = array();
        foreach($lastTransactionsSQLResult as $transaction)
        {
            array_push($lastTransactions, array(
                "customer" => $transaction['first_name']." ".$transaction['last_name'],
                "campaign" => $transaction['campaign_name'],
                "amount" => $transaction['amount'],
                "datetime" => $transaction['datetime_stamp']
            ));
        }
        return $lastTransactions;
    }

    /**
     * @param $transactionObject
     * @return array
     */
    public function formatTransactionObject($transactionObject)
    {
        if($transactionObject->getRedeemed() == "Y")
        {
            $type = "Earned";
        }
        else
        {
            $type = "Redeemed";
        }

        return array(
            'campaignId' => $transactionObject->getCampaignId(),
            'date' =>  $transactionObject->getDate(),
            'description' => $transactionObject->getAuthorization(),
            'type'  => $type,
            'amount' => $transactionObject->getAmount()
        );
    }

    /**
     * @param $transactionCollection
     * @return array
     */
    public function formatTransactionCollection($transactionCollection)
    {
        foreach($transactionCollection as $transactionObject)
        {
            $formattedTransactionCollection[] = self::formatTransactionObject($transactionObject);
        }
        return $formattedTransactionCollection;
    }

    /**
     * @param $lastTransactionsCollection
     * @return array
     */
    public function formatLastTransactionByCustomer($lastTransactionsCollection)
    {
        foreach($lastTransactionsCollection as $transaction)
        {
            $lastTransactions[] = array(
                'campaignName' => $transaction['campaign_name'],
                'campaignType' => $transaction['campaign_type'],
                'date' => $transaction['date'],
                'amount' => $transaction['amount']
            );
        }

        return $lastTransactions;
    }
}