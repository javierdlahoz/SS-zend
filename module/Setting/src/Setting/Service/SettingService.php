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
     */
    public function deleteByAccountId($accountId)
    {
        $settings = $this->getEntity()->findOneBy(array('account_id' => $accountId));

        $this->getPixiepadEntityManager()->remove($settings);
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

            $temp =$post->get('scanning_method');
            if(isset($temp))
            {
                $settings->setScanningMethod($post->get('scanning_method'));
            }

            $temp = $post->get('alert_preferences');
            if(isset($temp))
            {
                $settings->setAlertPreferences($post->get('alert_preferences'));
            }

            $temp = $post->get('allow_text_message_on_add');
            if(isset($temp))
            {
                $settings->setAllowTextMessageOnAdd($post->get('allow_text_message_on_add'));
            }

            $temp = $post->get('allow_text_message_on_redeem');
            if(isset($temp))
            {
                $settings->setAllowTextMessageOnRedeem($post->get('allow_text_message_on_redeem'));
            }

            $temp = $post->get('text_message_on_add');
            if(isset($temp))
            {
                $settings->setTextMessageOnAdd($post->get('text_message_on_add'));
            }

            $temp = $post->get('text_message_on_redeem');
            if(isset($temp))
            {
                $settings->setTextMessageOnRedeem($post->get('text_message_on_redeem'));
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
     */
    public function deleteCustomLanguage($accountId)
    {
        $customLanguage = $this->getCustomLanguageEntity()->findOneBy(array('account_id' => $accountId));

        if(!empty($customLanguage))
        {
            $this->getPixiepadEntityManager()->remove($customLanguage);
            $this->getPixiepadEntityManager()->flush();
        }
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