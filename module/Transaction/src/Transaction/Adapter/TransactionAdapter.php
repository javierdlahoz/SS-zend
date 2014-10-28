<?php

namespace Transaction\Adapter;

use Campaign\Service\CampaignService;
use Application\Adapter\StickyStreetAdapter;
use Transaction\Facade\CustomFieldFacade;

class TransactionAdapter extends StickyStreetAdapter
{
    const REDEEM = "redeem";
    const RECORD = "record_activity";
    const BATCH_TRANSACTIONS = "batch_transactions";
    const DELIMITER = "pipe";
    const APPLY_RATIO = "no";

    /**
     * @param $post
     * @internal param $accountId
     */
    public function addCustomFieldsToParams($post)
    {
        $customFields = CustomFieldFacade::formatCustomFieldCollection(
            $this->getServiceLocator()->get('transactionService')->getCustomFields($this->params['account_id']));

        foreach($customFields as $customField)
        {
            $temp = $post->get($customField['name']);
            if($temp != null)
            {
                $this->params[$customField['name']] = $temp;
            }
        }
    }

    /**
     * @param $customerCode
     * @param $campaignId
     * @param null $rewardId
     * @param null $points
     * @param null $dollars
     * @param null $authorization
     * @return bool
     */
    public function redeem($customerCode, $campaignId, $rewardId = null,
                           $points = null, $dollars = null,
                           $authorization = null)
    {
        $this->prepareParams($customerCode, $campaignId, $authorization);
        $this->params['type'] = self::REDEEM;

        $campaignType = $this->getServiceLocator()->get('campaignService')->getType($campaignId);
        switch($campaignType)
        {
            case CampaignService::POINTS:
                return $this->redeemPoints($rewardId, $points, $dollars);
                break;

            case CampaignService::GIFTCARDS:
                return $this->redeemGiftCard($points);
                break;

            default:
                if($rewardId == null)
                {
                    $rewardId = $points;
                }
                return $this->redeemGenerics($rewardId);
        }
    }

    /**
     * @param null $rewardId
     * @param null $points
     * @param null $dollars
     * @return bool
     */
    private function redeemPoints($rewardId = null, $points = null, $dollars = null)
    {
        if($rewardId != null)
        {
            $this->params['reward_to_redeem'] = $rewardId;
        }
        if($points != null)
        {
            $this->params['custom_points_redeem'] = $points;
        }
        elseif($dollars != null)
        {
            $this->params['custom_dollars_redeem'] = $dollars;
        }

        return $this->sendRequest();
    }

    /**
     * @param $amount
     * @return bool
     */
    private function redeemGiftCard($amount)
    {
        $this->params['reward_to_redeem'] = $amount;
        return $this->sendRequest();
    }

    /**
     * @param $rewardId
     * @return bool
     */
    private function redeemGenerics($rewardId)
    {
        $this->params['reward_to_redeem'] = $rewardId;
        return $this->sendRequest();
    }

    public function record($customerCode, $campaignId, $amount = null,
                           $sendEmail = null, $itemId = null,
                           $promoId = null, $authorization = null, $post)
    {
        $this->prepareParams($customerCode, $campaignId, $authorization);
        $this->params['type'] = self::RECORD;
        $this->addCustomFieldsToParams($post);

        if($sendEmail == "Y")
        {
            $this->params['send_transaction_email'] = $sendEmail;
        }

        $campaignType = $this->getServiceLocator()->get('campaignService')->getType($campaignId);
        switch($campaignType)
        {
            case CampaignService::POINTS:
                return $this->recordPoints($amount, $promoId);
                break;

            case CampaignService::GIFTCARDS:
                return $this->recordGiftCard($amount);
                break;

            case CampaignService::BUYX:
                return $this->recordBuyX($itemId, $amount);
                break;

            default:
                return $this->recordEvent();
        }
    }

    /**
     * @param null $amount
     * @param null $promoId
     * @return bool
     */
    private function recordPoints($amount = null, $promoId = null)
    {
        if($amount != null)
        {
            $this->params['amount'] = $amount;
        }
        if($promoId != null)
        {
            $this->params['promo_id'] = $promoId;
        }

        return $this->sendRequest();
    }

    /**
     * @return bool
     */
    private function recordEvent()
    {
        return $this->sendRequest();
    }

    /**
     * @param $amount
     * @return bool
     */
    private function recordGiftCard($amount)
    {
        $this->params['amount'] = $amount;
        return $this->sendRequest();
    }

    /**
     * @param $itemId
     * @param null $amount
     * @return bool
     */
    private function recordBuyX($itemId, $amount = null)
    {
        $this->params['service_product'] = $itemId;
        if($amount != null)
        {
            $this->params['buyx_quantity'] = $amount;
        }

        return $this->sendRequest();
    }

    /**
     * @param $amount
     * @param $campaignId
     * @param $customerCode
     * @param null $authorization
     * @param $promoId
     * @return bool
     * @throws \Exception
     */
    public function manuallyAddPoint($customerCode, $campaignId, $amount, $authorization = null, $promoId)
    {
        $this->prepareParams($customerCode, $campaignId, $authorization);
        $this->params['user_api_key'] = $this->params['user_password'];
        $this->params['API'] = self::API_VERSION;
        $this->params['type'] = self::BATCH_TRANSACTIONS;
        $this->params['delimiter'] = self::DELIMITER;
        $this->params['apply_ratio'] = self::APPLY_RATIO;
        
        $this->params['visits_header_1'] = "campaign_id";
        $this->params['visits_header_2'] = "code";
        $this->params['visits_header_3'] = "redeemed";
        $this->params['visits_header_4'] = "amount";
        $this->params['visits_header_5'] = "date";
        $this->params['visits_header_6'] = "authorization";

        if($authorization == null){
            $authorization = "";
        }

        if($promoId != null){
            $promoId = "|".$promoId;
        }

        unset($this->params['user_password']);
        unset($this->params['campaign_id']);

        $this->params['Visits_Data'] = "{$campaignId}|{$customerCode}|N|{$amount}||{$authorization}{$promoId}";

        return $this->sendRequest();
    }
}