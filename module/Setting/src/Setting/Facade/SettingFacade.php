<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/5/14
 * Time: 9:04 AM
 */

namespace Setting\Facade;

use Setting\Entity\CustomLanguage;
use Setting\Entity\Setting;

class SettingFacade
{
    /**
     * @param $settings
     * @return array
     */
    public function formatSettings(Setting $settings)
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
             'allow_new_custom' => $settings->getAllowNewCustom(),
             'scanning_method' => $settings->getScanningMethod(),
             'alert_preferences' => $settings->getAlertPreferences(),
             'allow_text_message_on_add' => $settings->getAllowTextMessageOnAdd(),
             'allow_text_message_on_redeem' => $settings->getAllowTextMessageOnRedeem(),
             'text_message_on_add' => $settings->getTextMessageOnAdd(),
             'text_message_on_redeem' => $settings->getTextMessageOnRedeem()
        );
    }

    /**
     * @param $customLanguage
     * @return array|null
     */
    public function formatCustomLanguage(CustomLanguage $customLanguage)
    {
        if(empty($customLanguage))
        {
            return null;
        }
        else
        {
            return array(
                "customLanguage" => json_decode($customLanguage->getCustomLanguage())
            );
        }
    }
}