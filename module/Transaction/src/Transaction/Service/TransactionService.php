<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/4/14
 * Time: 3:18 PM
 */

namespace Transaction\Service;

use Application\Service\AbstractService;
use Transaction\Entity\Transaction;

class TransactionService extends AbstractService
{

    const LIMIT = 20;

    public function getThisMonthTransactions($accountId)
    {
        $this->setEntity(self::VISIT.$accountId);
        $query = "WHERE date >= '{$this->getDates()->getStartDate()}' and date <= '{$this->getDates()->getEndDate()}'";
        $results = $this->count($query);

        return $results;
    }

    public function getLastTransaction($transactionNumber, $accountId)
    {
        $this->setAccountId($accountId);

        $fields = $this->prepareFieldsForLastTransactions();
        $entities = $this->prepareEntitiesForLastTransactions();
        $query = $this->prepareQueryForLastTransactions()." LIMIT ".$transactionNumber;

        $results = $this->select($fields, $query, $entities);
        return $results;
    }

    private function prepareFieldsForLastTransactions()
    {
        $entityNames = $this->getEntityNames();

        $fields = $entityNames['profiles'].".first_name, ".$entityNames['profiles'].".last_name, ";
        $fields .= $entityNames['visits'].".amount, ".$entityNames['visits'].".datetime_stamp, ";
        $fields .= "campaigns.campaign_name ";

        return $fields;
    }

    private function prepareEntitiesForLastTransactions()
    {
        $entityNames = $this->getEntityNames();
        return $entityNames['visits']." JOIN ".$entityNames['profiles']." JOIN campaigns";
    }

    private function prepareQueryForLastTransactions()
    {
        $entityNames = $this->getEntityNames();
        $query = " ON ".$entityNames['visits'].".campaign_id = campaigns.campaign_id AND ";
        $query .= $entityNames['visits'].".code = ".$entityNames['profiles'].".card_code ";
        $query .= " ORDER BY ".$entityNames['visits'].".datetime_stamp DESC ";

        return $query;
    }

    public function getByCode($code, $accountId)
    {
        $this->setEntity(self::VISIT.$accountId);
        $fields = "*";
        $query = "WHERE code='{$code}' LIMIT ".self::LIMIT;

        $sqlResults = $this->select($fields,$query);
        foreach($sqlResults as $sqlResult)
        {
            $transactions[] = new Transaction($sqlResult);
        }

        return $transactions;
    }

    public function getByCodeAndCampaignId($code, $campaignId, $accountId)
    {
        $this->setEntity(self::VISIT.$accountId);
        $fields = "*";
        $query = "WHERE code='{$code}' AND campaign_id='{$campaignId}' LIMIT ".self::LIMIT;

        $sqlResults = $this->select($fields,$query);
        foreach($sqlResults as $sqlResult)
        {
            $transactions[] = new Transaction($sqlResult);
        }

        return $transactions;
    }

    public function add($post, $accountId)
    {
        $this->setEntity(self::VISIT.$accountId);
        $transactionArray = array(
            'campaign_id' => $post->get('campaignId'),
            'code' => $post->get('code'),
            'amount' => $post->get('amount'),
            'service_product' => $post->get('serviceProduct'),
            'redeemed' => $post->get('redeemed'),
            'authorization' => $accountId,
            'undo_flag' => "N"
        );

        $this->insert($transactionArray);
    }
}