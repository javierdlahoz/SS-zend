<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/9/14
 * Time: 8:38 AM
 */
namespace Setting\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="823542_pixiedev.lp_settings")
 * @ORM\Entity
 */
class Setting
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(name="account_id", type="string", nullable=true)
     * @var string
     */
    private $account_id;

    /**
     * @ORM\Column(name="show_logo", type="boolean", nullable=true)
     * @var boolean
     */
    private $show_logo = false;

    /**
     * @ORM\Column(name="currency_glyph", type="string", nullable=true)
     * @var string
     */
    private $currency_glyph = "$";

    /**
     * @ORM\Column(name="allow_new_customers", type="boolean", nullable=true)
     * @var boolean
     */
    private $allow_new_customers = false;

    /**
     * @ORM\Column(name="add_currency_glyph", type="boolean", nullable=true)
     * @var boolean
     */
    private $add_currency_glyph = false;

    /**
     * @ORM\Column(name="deduct_currency_glyph", type="boolean", nullable=true)
     * @var boolean
     */
    private $deduct_currency_glyph = false;

    /**
     * @ORM\Column(name="date_format", type="string", nullable=true)
     * @var string
     */
    private $date_format = "d/m/Y";

    /**
     * @ORM\Column(name="money_format", type="string", nullable=true)
     * @var string
     */
    private $money_format = "%i";

    /**
     * @ORM\Column(name="allow_new_card_number", type="boolean", nullable=true)
     * @var boolean
     */
    private $allow_new_card_number = false;

    /**
     * @ORM\Column(name="allow_new_name", type="boolean", nullable=true)
     * @var boolean
     */
    private $allow_new_name = false;

    /**
     * @ORM\Column(name="allow_new_phone", type="boolean", nullable=true)
     * @var boolean
     */
    private $allow_new_phone = false;

    /**
     * @ORM\Column(name="allow_new_email", type="boolean", nullable=true)
     * @var boolean
     */
    private $allow_new_email = false;

    /**
     * @ORM\Column(name="allow_new_address", type="boolean", nullable=true)
     * @var boolean
     */
    private $allow_new_address = false;

    /**
     * @ORM\Column(name="allow_new_custom", type="boolean", nullable=true)
     * @var boolean
     */
    private $allow_new_custom = false;

    /**
     * @ORM\Column(name="allow_add", type="boolean", nullable=true)
     * @var boolean
     */
    private $allow_add = false;

    /**
     * @ORM\Column(name="allow_redeem_points", type="boolean", nullable=true)
     * @var boolean
     */
    private $allow_redeem_points = false;

    /**
     * @ORM\Column(name="ask_for_amount", type="boolean", nullable=true)
     * @var boolean
     */
    private $ask_for_amount = false;

    /**
     * @ORM\Column(name="ask_for_points", type="boolean", nullable=true)
     * @var boolean
     */
    private $ask_for_points = false;

    /**
     * @ORM\Column(name="ask_for_description", type="boolean", nullable=true)
     * @var boolean
     */
    private $ask_for_description = false;

    /**
     * @ORM\Column(name="ask_for_redeem_amount", type="boolean", nullable=true)
     * @var boolean
     */
    private $ask_for_redeem_amount = false;

    /**
     * @ORM\Column(name="ask_for_email_receipt", type="boolean", nullable=true)
     * @var boolean
     */
    private $ask_for_email_receipt = false;

    /**
     * @ORM\Column(name="show_rewards_not_earned", type="boolean", nullable=true)
     * @var boolean
     */
    private $show_rewards_not_earned = false;

    /**
     * @ORM\Column(name="show_transaction", type="boolean", nullable=true)
     * @var boolean
     */
    private $show_transaction = false;

    /**
     * @ORM\Column(name="gc_allow_add", type="boolean", nullable=true)
     * @var boolean
     */
    private $gc_allow_add = false;

    /**
     * @ORM\Column(name="gc_allow_redeem_points", type="boolean", nullable=true)
     * @var boolean
     */
    private $gc_allow_redeem_points = false;

    /**
     * @ORM\Column(name="gc_ask_for_redeem_amount", type="boolean", nullable=true)
     * @var boolean
     */
    private $gc_ask_for_redeem_amount = false;

    /**
     * @ORM\Column(name="gc_ask_for_email_receipt", type="boolean", nullable=true)
     * @var boolean
     */
    private $gc_ask_for_email_receipt = false;

    /**
     * @ORM\Column(name="gc_show_transaction", type="boolean", nullable=true)
     * @var boolean
     */
    private $gc_show_transaction = false;

    /**
     * @ORM\Column(name="gc_ask_for_amount", type="boolean", nullable=true)
     * @var boolean
     */
    private $gc_ask_for_amount = false;

    /**
     * @ORM\Column(name="ec_allow_add", type="boolean", nullable=true)
     * @var boolean
     */
    private $ec_allow_add = false;

    /**
     * @ORM\Column(name="ec_allow_redeem_points", type="boolean", nullable=true)
     * @var boolean
     */
    private $ec_allow_redeem_points = false;

    /**
     * @ORM\Column(name="ec_ask_for_email_receipt", type="boolean", nullable=true)
     * @var boolean
     */
    private $ec_ask_for_email_receipt = false;

    /**
     * @ORM\Column(name="ec_show_transaction", type="boolean", nullable=true)
     * @var boolean
     */
    private $ec_show_transaction = false;

    /**
     * @ORM\Column(name="ec_ask_for_description", type="boolean", nullable=true)
     * @var boolean
     */
    private $ec_ask_for_description = false;

    /**
     * @ORM\Column(name="ec_ask_for_amount", type="boolean", nullable=true)
     * @var boolean
     */
    private $ec_ask_for_amount = false;

    /**
     * @ORM\Column(name="bx_allow_add", type="boolean", nullable=true)
     * @var boolean
     */
    private $bx_allow_add = false;

    /**
     * @ORM\Column(name="bx_allow_redeem_points", type="boolean", nullable=true)
     * @var boolean
     */
    private $bx_allow_redeem_points = false;

    /**
     * @ORM\Column(name="bx_ask_for_email_receipt", type="boolean", nullable=true)
     * @var boolean
     */
    private $bx_ask_for_email_receipt = false;

    /**
     * @ORM\Column(name="bx_show_transaction", type="boolean", nullable=true)
     * @var boolean
     */
    private $bx_show_transaction = false;

    /**
     * @ORM\Column(name="bx_ask_for_description", type="boolean", nullable=true)
     * @var boolean
     */
    private $bx_ask_for_description = false;

    /**
     * @ORM\Column(name="bx_ask_for_amount", type="boolean", nullable=true)
     * @var boolean
     */
    private $bx_ask_for_amount = false;

    /**
     * @ORM\Column(name="scanning_method", type="string", nullable=true)
     * @var string
     */
    private $scanning_method = "qr";

    /**
     * @ORM\Column(name="alert_preferences", type="string", nullable=true)
     * @var string
     */
    private $alert_preferences = "email";

    /**
     * @param mixed $account_id
     */
    public function setAccountId($account_id)
    {
        $this->account_id = $account_id;
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * @param mixed $add_currency_glyph
     */
    public function setAddCurrencyGlyph($add_currency_glyph)
    {
        $this->add_currency_glyph = $add_currency_glyph;
    }

    /**
     * @return mixed
     */
    public function getAddCurrencyGlyph()
    {
        return $this->add_currency_glyph;
    }

    /**
     * @param mixed $allow_add
     */
    public function setAllowAdd($allow_add)
    {
        $this->allow_add = $allow_add;
    }

    /**
     * @return mixed
     */
    public function getAllowAdd()
    {
        return $this->allow_add;
    }

    /**
     * @param mixed $allow_new_address
     */
    public function setAllowNewAddress($allow_new_address)
    {
        $this->allow_new_address = $allow_new_address;
    }

    /**
     * @return mixed
     */
    public function getAllowNewAddress()
    {
        return $this->allow_new_address;
    }

    /**
     * @param mixed $allow_new_card_number
     */
    public function setAllowNewCardNumber($allow_new_card_number)
    {
        $this->allow_new_card_number = $allow_new_card_number;
    }

    /**
     * @return mixed
     */
    public function getAllowNewCardNumber()
    {
        return $this->allow_new_card_number;
    }

    /**
     * @param mixed $allow_new_custom
     */
    public function setAllowNewCustom($allow_new_custom)
    {
        $this->allow_new_custom = $allow_new_custom;
    }

    /**
     * @return mixed
     */
    public function getAllowNewCustom()
    {
        return $this->allow_new_custom;
    }

    /**
     * @param mixed $allow_new_customers
     */
    public function setAllowNewCustomers($allow_new_customers)
    {
        $this->allow_new_customers = $allow_new_customers;
    }

    /**
     * @return mixed
     */
    public function getAllowNewCustomers()
    {
        return $this->allow_new_customers;
    }

    /**
     * @param mixed $allow_new_email
     */
    public function setAllowNewEmail($allow_new_email)
    {
        $this->allow_new_email = $allow_new_email;
    }

    /**
     * @return mixed
     */
    public function getAllowNewEmail()
    {
        return $this->allow_new_email;
    }

    /**
     * @param mixed $allow_new_name
     */
    public function setAllowNewName($allow_new_name)
    {
        $this->allow_new_name = $allow_new_name;
    }

    /**
     * @return mixed
     */
    public function getAllowNewName()
    {
        return $this->allow_new_name;
    }

    /**
     * @param mixed $allow_new_phone
     */
    public function setAllowNewPhone($allow_new_phone)
    {
        $this->allow_new_phone = $allow_new_phone;
    }

    /**
     * @return mixed
     */
    public function getAllowNewPhone()
    {
        return $this->allow_new_phone;
    }

    /**
     * @param mixed $allow_redeem_points
     */
    public function setAllowRedeemPoints($allow_redeem_points)
    {
        $this->allow_redeem_points = $allow_redeem_points;
    }

    /**
     * @return mixed
     */
    public function getAllowRedeemPoints()
    {
        return $this->allow_redeem_points;
    }

    /**
     * @param mixed $ask_for_amount
     */
    public function setAskForAmount($ask_for_amount)
    {
        $this->ask_for_amount = $ask_for_amount;
    }

    /**
     * @return mixed
     */
    public function getAskForAmount()
    {
        return $this->ask_for_amount;
    }

    /**
     * @param mixed $ask_for_description
     */
    public function setAskForDescription($ask_for_description)
    {
        $this->ask_for_description = $ask_for_description;
    }

    /**
     * @return mixed
     */
    public function getAskForDescription()
    {
        return $this->ask_for_description;
    }

    /**
     * @param mixed $ask_for_email_receipt
     */
    public function setAskForEmailReceipt($ask_for_email_receipt)
    {
        $this->ask_for_email_receipt = $ask_for_email_receipt;
    }

    /**
     * @return mixed
     */
    public function getAskForEmailReceipt()
    {
        return $this->ask_for_email_receipt;
    }

    /**
     * @param mixed $ask_for_points
     */
    public function setAskForPoints($ask_for_points)
    {
        $this->ask_for_points = $ask_for_points;
    }

    /**
     * @return mixed
     */
    public function getAskForPoints()
    {
        return $this->ask_for_points;
    }

    /**
     * @param mixed $ask_for_redeem_amount
     */
    public function setAskForRedeemAmount($ask_for_redeem_amount)
    {
        $this->ask_for_redeem_amount = $ask_for_redeem_amount;
    }

    /**
     * @return mixed
     */
    public function getAskForRedeemAmount()
    {
        return $this->ask_for_redeem_amount;
    }

    /**
     * @param mixed $bk_allow_add
     */
    public function setBxAllowAdd($bk_allow_add)
    {
        $this->bx_allow_add = $bk_allow_add;
    }

    /**
     * @return mixed
     */
    public function getBxAllowAdd()
    {
        return $this->bx_allow_add;
    }

    /**
     * @param mixed $bk_allow_redeem_points
     */
    public function setBxAllowRedeemPoints($bk_allow_redeem_points)
    {
        $this->bx_allow_redeem_points = $bk_allow_redeem_points;
    }

    /**
     * @return mixed
     */
    public function getBxAllowRedeemPoints()
    {
        return $this->bx_allow_redeem_points;
    }

    /**
     * @param mixed $bk_ask_for_amount
     */
    public function setBxAskForAmount($bk_ask_for_amount)
    {
        $this->bx_ask_for_amount = $bk_ask_for_amount;
    }

    /**
     * @return mixed
     */
    public function getBxAskForAmount()
    {
        return $this->bx_ask_for_amount;
    }

    /**
     * @param mixed $bk_ask_for_description
     */
    public function setBxAskForDescription($bk_ask_for_description)
    {
        $this->bx_ask_for_description = $bk_ask_for_description;
    }

    /**
     * @return mixed
     */
    public function getBxAskForDescription()
    {
        return $this->bx_ask_for_description;
    }

    /**
     * @param mixed $bk_ask_for_email_receipt
     */
    public function setBxAskForEmailReceipt($bk_ask_for_email_receipt)
    {
        $this->bx_ask_for_email_receipt = $bk_ask_for_email_receipt;
    }

    /**
     * @return mixed
     */
    public function getBxAskForEmailReceipt()
    {
        return $this->bx_ask_for_email_receipt;
    }

    /**
     * @param mixed $bk_show_transaction
     */
    public function setBxShowTransaction($bk_show_transaction)
    {
        $this->bx_show_transaction = $bk_show_transaction;
    }

    /**
     * @return mixed
     */
    public function getBxShowTransaction()
    {
        return $this->bx_show_transaction;
    }

    /**
     * @param mixed $currency_glyph
     */
    public function setCurrencyGlyph($currency_glyph)
    {
        $this->currency_glyph = $currency_glyph;
    }

    /**
     * @return mixed
     */
    public function getCurrencyGlyph()
    {
        return $this->currency_glyph;
    }

    /**
     * @param mixed $date_format
     */
    public function setDateFormat($date_format)
    {
        $this->date_format = $date_format;
    }

    /**
     * @return mixed
     */
    public function getDateFormat()
    {
        return $this->date_format;
    }

    /**
     * @param mixed $deduct_currency_glyph
     */
    public function setDeductCurrencyGlyph($deduct_currency_glyph)
    {
        $this->deduct_currency_glyph = $deduct_currency_glyph;
    }

    /**
     * @return mixed
     */
    public function getDeductCurrencyGlyph()
    {
        return $this->deduct_currency_glyph;
    }

    /**
     * @param mixed $ec_allow_add
     */
    public function setEcAllowAdd($ec_allow_add)
    {
        $this->ec_allow_add = $ec_allow_add;
    }

    /**
     * @return mixed
     */
    public function getEcAllowAdd()
    {
        return $this->ec_allow_add;
    }

    /**
     * @param mixed $ec_allow_redeem_points
     */
    public function setEcAllowRedeemPoints($ec_allow_redeem_points)
    {
        $this->ec_allow_redeem_points = $ec_allow_redeem_points;
    }

    /**
     * @return mixed
     */
    public function getEcAllowRedeemPoints()
    {
        return $this->ec_allow_redeem_points;
    }

    /**
     * @param mixed $ec_ask_for_amount
     */
    public function setEcAskForAmount($ec_ask_for_amount)
    {
        $this->ec_ask_for_amount = $ec_ask_for_amount;
    }

    /**
     * @return mixed
     */
    public function getEcAskForAmount()
    {
        return $this->ec_ask_for_amount;
    }

    /**
     * @param mixed $ec_ask_for_description
     */
    public function setEcAskForDescription($ec_ask_for_description)
    {
        $this->ec_ask_for_description = $ec_ask_for_description;
    }

    /**
     * @return mixed
     */
    public function getEcAskForDescription()
    {
        return $this->ec_ask_for_description;
    }

    /**
     * @param mixed $ec_ask_for_email_receipt
     */
    public function setEcAskForEmailReceipt($ec_ask_for_email_receipt)
    {
        $this->ec_ask_for_email_receipt = $ec_ask_for_email_receipt;
    }

    /**
     * @return mixed
     */
    public function getEcAskForEmailReceipt()
    {
        return $this->ec_ask_for_email_receipt;
    }

    /**
     * @param mixed $ec_show_transaction
     */
    public function setEcShowTransaction($ec_show_transaction)
    {
        $this->ec_show_transaction = $ec_show_transaction;
    }

    /**
     * @return mixed
     */
    public function getEcShowTransaction()
    {
        return $this->ec_show_transaction;
    }

    /**
     * @param mixed $gc_allow_add
     */
    public function setGcAllowAdd($gc_allow_add)
    {
        $this->gc_allow_add = $gc_allow_add;
    }

    /**
     * @return mixed
     */
    public function getGcAllowAdd()
    {
        return $this->gc_allow_add;
    }

    /**
     * @param mixed $gc_allow_redeem_points
     */
    public function setGcAllowRedeemPoints($gc_allow_redeem_points)
    {
        $this->gc_allow_redeem_points = $gc_allow_redeem_points;
    }

    /**
     * @return mixed
     */
    public function getGcAllowRedeemPoints()
    {
        return $this->gc_allow_redeem_points;
    }

    /**
     * @param mixed $gc_ask_for_amount
     */
    public function setGcAskForAmount($gc_ask_for_amount)
    {
        $this->gc_ask_for_amount = $gc_ask_for_amount;
    }

    /**
     * @return mixed
     */
    public function getGcAskForAmount()
    {
        return $this->gc_ask_for_amount;
    }

    /**
     * @param mixed $gc_ask_for_email_receipt
     */
    public function setGcAskForEmailReceipt($gc_ask_for_email_receipt)
    {
        $this->gc_ask_for_email_receipt = $gc_ask_for_email_receipt;
    }

    /**
     * @return mixed
     */
    public function getGcAskForEmailReceipt()
    {
        return $this->gc_ask_for_email_receipt;
    }

    /**
     * @param mixed $gc_ask_for_redeem_amount
     */
    public function setGcAskForRedeemAmount($gc_ask_for_redeem_amount)
    {
        $this->gc_ask_for_redeem_amount = $gc_ask_for_redeem_amount;
    }

    /**
     * @return mixed
     */
    public function getGcAskForRedeemAmount()
    {
        return $this->gc_ask_for_redeem_amount;
    }

    /**
     * @param mixed $gc_show_transaction
     */
    public function setGcShowTransaction($gc_show_transaction)
    {
        $this->gc_show_transaction = $gc_show_transaction;
    }

    /**
     * @return mixed
     */
    public function getGcShowTransaction()
    {
        return $this->gc_show_transaction;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $money_format
     */
    public function setMoneyFormat($money_format)
    {
        $this->money_format = $money_format;
    }

    /**
     * @return mixed
     */
    public function getMoneyFormat()
    {
        return $this->money_format;
    }

    /**
     * @param mixed $show_logo
     */
    public function setShowLogo($show_logo)
    {
        $this->show_logo = $show_logo;
    }

    /**
     * @return mixed
     */
    public function getShowLogo()
    {
        return $this->show_logo;
    }

    /**
     * @param mixed $show_rewards_not_earned
     */
    public function setShowRewardsNotEarned($show_rewards_not_earned)
    {
        $this->show_rewards_not_earned = $show_rewards_not_earned;
    }

    /**
     * @return mixed
     */
    public function getShowRewardsNotEarned()
    {
        return $this->show_rewards_not_earned;
    }

    /**
     * @param mixed $show_transaction
     */
    public function setShowTransaction($show_transaction)
    {
        $this->show_transaction = $show_transaction;
    }

    /**
     * @return mixed
     */
    public function getShowTransaction()
    {
        return $this->show_transaction;
    }

    /**
     * @param string $alert_preferences
     */
    public function setAlertPreferences($alert_preferences)
    {
        $this->alert_preferences = $alert_preferences;
    }

    /**
     * @return string
     */
    public function getAlertPreferences()
    {
        return $this->alert_preferences;
    }

    /**
     * @param string $scanning_method
     */
    public function setScanningMethod($scanning_method)
    {
        $this->scanning_method = $scanning_method;
    }

    /**
     * @return string
     */
    public function getScanningMethod()
    {
        return $this->scanning_method;
    }

}