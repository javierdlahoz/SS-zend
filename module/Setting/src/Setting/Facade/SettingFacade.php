<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/5/14
 * Time: 9:04 AM
 */

namespace Setting\Facade;

class SettingFacade
{
    public function formatSettings($settings)
    {
         return array(
            'show_logo' => $settings->getShowLogo(),
            'currency_glyph' => $settings->getCurrencyGlyph(),
            'allow_new_customers' => $settings->getAllowNewCustomers(),
            'add_currency_glyph' => $settings->getAddCurrencyGlyph(),
            'deduct_currency_glyph' => $settings->getDeductCurrencyGlyph(),
            'date_format' => $settings->getDateFormat(),
            'money_format' => $settings->getMoneyFormat(),
            'allow_new_card_number' => $settings->getAllowNewCardNumber(),
            'allow_new_name' => $settings->getAllowNewName(),
            'allow_new_phone' => $settings->getAllowNewPhone(),
            'allow_new_email' => $settings->getAllowNewEmail(),
            'allow_new_address' => $settings->getAllowNewAddress(),
            'allow_new_custom' => $settings->getAllowNewCustom(),/*
            'allow_add' => $settings->getAllowAdd(),
            'allow_redeem_points' => $settings->getAllowRedeemPoints(),
            'ask_for_amount' => $settings->getAskForAmount(),
            'ask_for_points' => $settings->getAskForPoints(),
            'ask_for_description' => $settings->getAskForDescription(),
            'ask_for_redeem_amount' => $settings->getAskForRedeemAmount(),
            'ask_for_email_receipt' => $settings->getAskForEmailReceipt(),
            'show_rewards_not_earned' => $settings->getShowRewardsNotEarned(),
            'show_transaction' => $settings->getShowTransaction(),
            'gc_allow_add' => $settings->getGcAllowAdd(),
            'gc_allow_redeem_points' => $settings->getGcAllowRedeemPoints(),
            'gc_ask_for_redeem_amount' => $settings->getGcAskForRedeemAmount(),
            'gc_ask_for_email_receipt' => $settings->getGcAskForEmailReceipt(),
            'gc_show_transaction' => $settings->getGcShowTransaction(),
            'gc_ask_for_amount' => $settings->getGcAskForAmount(),
            'ec_allow_add' => $settings->getEcAllowAdd(),
            'ec_allow_redeem_points' => $settings->getEcAllowRedeemPoints(),
            'ec_ask_for_email_receipt' => $settings->getEcAskForEmailReceipt(),
            'ec_show_transaction' => $settings->getEcShowTransaction(),
            'ec_ask_for_description' => $settings->getEcAskForDescription(),
            'ec_ask_for_amount' => $settings->getEcAskForAmount(),
            'bx_allow_add' => $settings->getBxAllowAdd(),
            'bx_allow_redeem_points' => $settings->getBxAllowRedeemPoints(),
            'bx_ask_for_email_receipt' => $settings->getBxAskForEmailReceipt(),
            'bx_show_transaction' => $settings->getBxShowTransaction(),
            'bx_ask_for_description' => $settings->getBxAskForDescription(),
            'bx_ask_for_amount' => $settings->getBxAskForAmount(),*/
            'scanning_method' => $settings->getScanningMethod(),
            'alert_preferences' => $settings->getAlertPreferences()
        );
    }
}