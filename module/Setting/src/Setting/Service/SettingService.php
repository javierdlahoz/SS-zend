<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/4/14
 * Time: 3:18 PM
 */

namespace Setting\Service;

use Application\Service\DoctrineService;
use Setting\Entity\Setting;
use Setting\Entity\CustomLanguage;

class SettingService extends DoctrineService
{
    const ENTITY_NAME = 'Setting\Entity\Setting';
    const CUSTOM_LANGUAGE_ENTITY = 'Setting\Entity\CustomLanguage';


    public function init()
    {
        $entityManager = $this->getPixiepadEntityManager();
        $this->setEntity($entityManager->getRepository(self::ENTITY_NAME));
    }

    /**
     * @return mixed
     */
    private function getCustomLanguageEntity()
    {
        $entityManager = $this->getPixiepadEntityManager();
        return $entityManager->getRepository(self::CUSTOM_LANGUAGE_ENTITY);
    }

    /**
     * @param $accountId
     * @return mixed
     */
    public function getByAccountId($accountId)
    {
        return $this->getEntity()->findBy(array('account_id' => $accountId));
    }

    /**
     * @param $accountId
     */
    public function createByAccountId($accountId)
    {
        $settings = new Setting();

        $settings->setAccountId($accountId);
        $this->getPixiepadEntityManager()->persist($settings);
        $this->getPixiepadEntityManager()->flush();
    }

    /**
     * @param $accountId
     * @param $post
     * @throws \Exception
     */
    public function editByAccountId($accountId, $post)
    {
        $settings = $this->getByAccountId($accountId);
        $settings = $settings[0];

        if($settings instanceof Setting)
        {
            $temp =$post->get('show_logo');
            if(isset($temp))
            {
                $settings->setShowLogo($post->get('show_logo'));
            }

            $temp =$post->get('currency_glyph');
            if(isset($temp))
            {
                $settings->setCurrencyGlyph($post->get('currency_glyph'));
            }

            $temp =$post->get('allow_new_customers');
            if(isset($temp))
            {
                $settings->setAllowNewCustomers($post->get('allow_new_customers'));
            }

            $temp =$post->get('add_currency_glyph');
            if(isset($temp))
            {
                $settings->setAddCurrencyGlyph($post->get('add_currency_glyph'));
            }

            $temp =$post->get('deduct_currency_glyph');
            if(isset($temp))
            {
                $settings->setDeductCurrencyGlyph($post->get('deduct_currency_glyph'));
            }

            $temp =$post->get('date_format');
            if(isset($temp))
            {
                $settings->setDateFormat($post->get('date_format'));
            }

            $temp =$post->get('money_format');
            if(isset($temp))
            {
                $settings->setMoneyFormat($post->get('money_format'));
            }

            $temp =$post->get('allow_new_card_number');
            if(isset($temp))
            {
                $settings->setAllowNewCardNumber($post->get('allow_new_card_number'));
            }

            $temp =$post->get('allow_new_name');
            if(isset($temp))
            {
                $settings->setAllowNewName($post->get('allow_new_name'));
            }

            $temp =$post->get('allow_new_phone');
            if(isset($temp))
            {
                $settings->setAllowNewPhone($post->get('allow_new_phone'));
            }

            $temp =$post->get('allow_new_email');
            if(isset($temp))
            {
                $settings->setAllowNewEmail($post->get('allow_new_email'));
            }

            $temp =$post->get('allow_new_address');
            if(isset($temp))
            {
                $settings->setAllowNewAddress($post->get('allow_new_address'));
            }

            $temp =$post->get('allow_new_custom');
            if(isset($temp))
            {
                $settings->setAllowNewCustom($post->get('allow_new_custom'));
            }

            $temp =$post->get('allow_add');
            if(isset($temp))
            {
                $settings->setAllowAdd($post->get('allow_add'));
            }

            $temp =$post->get('allow_redeem_points');
            if(isset($temp))
            {
                $settings->setAllowRedeemPoints($post->get('allow_redeem_points'));
            }

            $temp =$post->get('ask_for_amount');
            if(isset($temp))
            {
                $settings->setAskForAmount($post->get('ask_for_amount'));
            }

            $temp =$post->get('ask_for_points');
            if(isset($temp))
            {
                $settings->setAskForPoints($post->get('ask_for_points'));
            }

            $temp =$post->get('ask_for_description');
            if(isset($temp))
            {
                $settings->setAskForDescription($post->get('ask_for_description'));
            }

            $temp =$post->get('ask_for_redeem_amount');
            if(isset($temp))
            {
                $settings->setAskForRedeemAmount($post->get('ask_for_redeem_amount'));
            }

            $temp =$post->get('ask_for_email_receipt');
            if(isset($temp))
            {
                $settings->setAskForEmailReceipt($post->get('ask_for_email_receipt'));
            }

            $temp =$post->get('show_rewards_not_earned');
            if(isset($temp))
            {
                $settings->setShowRewardsNotEarned($post->get('show_rewards_not_earned'));
            }

            $temp =$post->get('show_transaction');
            if(isset($temp))
            {
                $settings->setShowTransaction($post->get('show_transaction'));
            }

            $temp =$post->get('gc_allow_add');
            if(isset($temp))
            {
                $settings->setGcAllowAdd($post->get('gc_allow_add'));
            }

            $temp =$post->get('gc_allow_redeem_points');
            if(isset($temp))
            {
                $settings->setGcAllowRedeemPoints($post->get('gc_allow_redeem_points'));
            }

            $temp =$post->get('gc_ask_for_redeem_amount');
            if(isset($temp))
            {
                $settings->setGcAskForRedeemAmount($post->get('gc_ask_for_redeem_amount'));
            }

            $temp =$post->get('gc_ask_for_email_receipt');
            if(isset($temp))
            {
                $settings->setGcAskForEmailReceipt($post->get('gc_ask_for_email_receipt'));
            }

            $temp =$post->get('gc_show_transaction');
            if(isset($temp))
            {
                $settings->setGcShowTransaction($post->get('gc_show_transaction'));
            }

            $temp =$post->get('gc_ask_for_amount');
            if(isset($temp))
            {
                $settings->setGcAskForAmount($post->get('gc_ask_for_amount'));
            }

            $temp =$post->get('ec_allow_add');
            if(isset($temp))
            {
                $settings->setEcAllowAdd($post->get('ec_allow_add'));
            }

            $temp =$post->get('ec_allow_redeem_points');
            if(isset($temp))
            {
                $settings->setEcAllowRedeemPoints($post->get('ec_allow_redeem_points'));
            }

            $temp =$post->get('ec_ask_for_email_receipt');
            if(isset($temp))
            {
                $settings->setEcAskForEmailReceipt($post->get('ec_ask_for_email_receipt'));
            }

            $temp =$post->get('ec_show_transaction');
            if(isset($temp))
            {
                $settings->setEcShowTransaction($post->get('ec_show_transaction'));
            }

            $temp =$post->get('ec_ask_for_description');
            if(isset($temp))
            {
                $settings->setEcAskForDescription($post->get('ec_ask_for_description'));
            }

            $temp =$post->get('ec_ask_for_amount');
            if(isset($temp))
            {
                $settings->setEcAskForAmount($post->get('ec_ask_for_amount'));
            }

            $temp =$post->get('bx_allow_add');
            if(isset($temp))
            {
                $settings->setBxAllowAdd($post->get('bx_allow_add'));
            }

            $temp =$post->get('bx_allow_redeem_points');
            if(isset($temp))
            {
                $settings->setBxAllowRedeemPoints($post->get('bx_allow_redeem_points'));
            }

            $temp =$post->get('bx_ask_for_email_receipt');
            if(isset($temp))
            {
                $settings->setBxAskForEmailReceipt($post->get('bx_ask_for_email_receipt'));
            }

            $temp =$post->get('bx_show_transaction');
            if(isset($temp))
            {
                $settings->setBxShowTransaction($post->get('bx_show_transaction'));
            }

            $temp =$post->get('bx_ask_for_description');
            if(isset($temp))
            {
                $settings->setBxAskForDescription($post->get('bx_ask_for_description'));
            }

            $temp =$post->get('bx_ask_for_amount');
            if(isset($temp))
            {
                $settings->setBxAskForAmount($post->get('bx_ask_for_amount'));
            }

            $temp =$post->get('scanning_method');
            if(isset($temp))
            {
                $settings->setScanningMethod($post->get('scanning_method'));
            }

            $temp =$post->get('alert_preferences');
            if(isset($temp))
            {
                $settings->setAlertPreferences($post->get('alert_preferences'));
            }

            try{
                $this->getPixiepadEntityManager()->merge($settings);
                $this->getPixiepadEntityManager()->flush();
                return true;
            }
            catch(\Exception $ex)
            {
                throw new \Exception($ex);
            }
        }
        else
        {
            throw new \Exception('No settings were found');
        }
    }

    /**
     * @param $accountId
     * @return mixed
     */
    public function getCustomLanguage($accountId)
    {
        return $this->getCustomLanguageEntity()->findOneBy(array('account_id' => $accountId));
    }

    /**
     * @param $accountId
     * @return bool
     */
    private function existCustomLanguage($accountId)
    {
        $customLanguage = self::getCustomLanguage($accountId);
        if(!empty($customLanguage))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $accountId
     * @param $customLanguage
     * @throws \Exception
     */
    public function saveCustomLanguage($accountId, $customLanguage)
    {
        try
        {
            if (self::existCustomLanguage($accountId))
            {
                $customLanguageTemp = self::getCustomLanguage($accountId);

                $customLanguageTemp->setCustomLanguage($customLanguage);
                $this->getPixiepadEntityManager()->merge($customLanguageTemp);
                $this->getPixiepadEntityManager()->flush();
            }
            else
            {
                $customLanguageTemp = new CustomLanguage();
                $customLanguageTemp->setAccountId($accountId);
                $customLanguageTemp->setCustomLanguage($customLanguage);

                $this->getPixiepadEntityManager()->persist($customLanguageTemp);
                $this->getPixiepadEntityManager()->flush();
            }
        }
        catch(\Exception $ex)
        {
            throw new \Exception($ex->getMessage());
        }
    }
}