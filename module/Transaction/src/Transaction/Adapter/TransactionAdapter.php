<?php

namespace Transaction\Adapter;

use Campaign\Service\CampaignService;
use Application\Adapter\StickyStreetAdapter;

class TransactionAdapter extends StickyStreetAdapter
{
    const REDEEM = "redeem";
    const RECORD = "record_activity";

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
        elseif($points != null)
        {
            $this->params['custom_points_redeem'] = $rewardId;
        }
        elseif($dollars != null)
        {
            $this->params['custom_dollars_redeem'] = $rewardId;
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
                           $sendEmail = null, $serviceProduct = null,
                           $buyXQty = null, $promoId = null, $authorization = null)
    {
        $this->prepareParams($customerCode, $campaignId, $authorization);
        $this->params['type'] = self::RECORD;

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
                return $this->recordBuyX($serviceProduct, $buyXQty);
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
        elseif($promoId != null)
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
     * @param $serviceProduct
     * @param null $buyXQty
     * @return bool
     */
    private function recordBuyX($serviceProduct, $buyXQty = null)
    {
        $this->params['service_product'] = $serviceProduct;
        if($buyXQty != null)
        {
            $this->params['buyx_quantity'] = $buyXQty;
        }

        return $this->sendRequest();
    }
}