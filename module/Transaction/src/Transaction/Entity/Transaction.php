<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/12/14
 * Time: 2:12 PM
 */

namespace Transaction\Entity;


class Transaction{

    function __construct($SQLData)
    {
        foreach($SQLData as $key => $value)
        {
            try{
                $this->{$key} = $value;
            }
            catch(\Exception $ex)
            {
                //nothing here
            }
        }
    }

    private $unique_id;

    private $campaign_id;

    private $code;

    private $date;

    private $amount;

    private $service_product;

    private $redeemed;

    private $authorization;

    private $user_name;

    private $undo_date;

    private $undo_which;

    private $orig_amount;

    private $datetime_stamp;

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $authorization
     */
    public function setAuthorization($authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * @return mixed
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @param mixed $campaign_id
     */
    public function setCampaignId($campaign_id)
    {
        $this->campaign_id = $campaign_id;
    }

    /**
     * @return mixed
     */
    public function getCampaignId()
    {
        return $this->campaign_id;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $datetime_stamp
     */
    public function setDatetimeStamp($datetime_stamp)
    {
        $this->datetime_stamp = $datetime_stamp;
    }

    /**
     * @return mixed
     */
    public function getDatetimeStamp()
    {
        return $this->datetime_stamp;
    }

    /**
     * @param mixed $orig_amount
     */
    public function setOrigAmount($orig_amount)
    {
        $this->orig_amount = $orig_amount;
    }

    /**
     * @return mixed
     */
    public function getOrigAmount()
    {
        return $this->orig_amount;
    }

    /**
     * @param mixed $redeemed
     */
    public function setRedeemed($redeemed)
    {
        $this->redeemed = $redeemed;
    }

    /**
     * @return mixed
     */
    public function getRedeemed()
    {
        return $this->redeemed;
    }

    /**
     * @param mixed $service_product
     */
    public function setServiceProduct($service_product)
    {
        $this->service_product = $service_product;
    }

    /**
     * @return mixed
     */
    public function getServiceProduct()
    {
        return $this->service_product;
    }

    /**
     * @param mixed $undo_date
     */
    public function setUndoDate($undo_date)
    {
        $this->undo_date = $undo_date;
    }

    /**
     * @return mixed
     */
    public function getUndoDate()
    {
        return $this->undo_date;
    }

    /**
     * @param mixed $undo_which
     */
    public function setUndoWhich($undo_which)
    {
        $this->undo_which = $undo_which;
    }

    /**
     * @return mixed
     */
    public function getUndoWhich()
    {
        return $this->undo_which;
    }

    /**
     * @param mixed $unique_id
     */
    public function setUniqueId($unique_id)
    {
        $this->unique_id = $unique_id;
    }

    /**
     * @return mixed
     */
    public function getUniqueId()
    {
        return $this->unique_id;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->user_name;
    }

} 