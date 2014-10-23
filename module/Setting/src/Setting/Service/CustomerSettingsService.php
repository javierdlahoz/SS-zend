<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/4/14
 * Time: 3:18 PM
 */

namespace Setting\Service;

use Application\Service\DoctrineService;
use Setting\Entity\Customer;
use Setting\Facade\CustomerSettingFacade;

class CustomerSettingsService extends DoctrineService
{
    const ENTITY_NAME = 'Setting\Entity\Customer';
    const ENTITY_CUSTOM_FIELDS = 'Setting\Entity\CustomField';

    /**
     * @throws \Exception
     */
    public function init()
    {
        $entityManager = $this->getPixiepadEntityManager();
        try{
            $this->setEntity($entityManager->getRepository(self::ENTITY_NAME));
        }
        catch(\Exception $ex)
        {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $accountId
     * @return mixed
     */
    private function getCustomFields($accountId)
    {
        $customFieldEntity =  $this->getEntityManager()->getRepository(self::ENTITY_CUSTOM_FIELDS);
        $customFields = $customFieldEntity->findBy(array('account_id' => $accountId));

        return $customFields;
    }

    /**
     * @return array
     */
    private function getAllFields()
    {
        return array(
            'card_number' => "Card #",
            'first_name' => "First Name",
            'last_name' => "Last Name",
            'city' => "City",
            'country' => "Country",
            'custom_date' => "Birthday",
            'email' => "Email Address",
            'phone' => "Phone Number",
            'state' => "State / Province",
            'street1' => "Address Line 1",
            'street2' => "Address Line 2",
            'zip' => "Zip / Postal Code"
        );
    }

    /**
     * @param $accountId
     * @return mixed
     */
    public function getByAccountId($accountId)
    {
        $customerSettings = $this->getEntity()->findBy(array('account_id' => $accountId));
        $customFields = $this->getServiceLocator()->get('customerService')->getCustomFields($accountId);
        self::validateAllStored($customFields, $customerSettings);

        return $this->getEntity()->findBy(array('account_id' => $accountId));
    }

    /**
     * @param $accountId
     */
    public function createByAccountId($accountId)
    {
        $customerFields = $this->getAllFields();

        foreach($customerFields as $key => $value)
        {
            $customerSettings = new Customer();

            $customerSettings->setAccountId($accountId);
            $customerSettings->setCustomFieldName($key);
            $customerSettings->setCustomFieldLabel($value);
            $customerSettings->setCustomFieldType("Text");
            $customerSettings->setCustomFieldShow("Y");
            $customerSettings->setIsAvailable(1);

            $this->getPixiepadEntityManager()->persist($customerSettings);
            $this->getPixiepadEntityManager()->flush();
        }

        $customFields = $this->getServiceLocator()->get('customerService')->getCustomFields($accountId);

        foreach($customFields as $customField)
        {
            self::createCustomerSettingEntry($accountId, $customField);
        }

    }

    /**
     * @param $accountId
     * @param $post
     * @return bool
     * @throws \Exception
     */
    public function editByAccountId($accountId, $post)
    {
        $customerSettings = $this->getByAccountId($accountId);
        foreach($customerSettings as $customerSetting)
        {
            $fieldValue = $post->get($customerSetting->getCustomFieldName());
            if(!empty($fieldValue))
            {
                $customerSetting->setCustomFieldShow($fieldValue);
            }
            try{
                $this->getPixiepadEntityManager()->merge($customerSetting);
                $this->getPixiepadEntityManager()->flush();
            }
            catch(\Exception $ex)
            {
                throw new \Exception("Something failed");
                return false;
            }
        }
        return true;
    }

    /**
     * @param $accountId
     */
    public function deleteByAccountId($accountId)
    {
        $customerSettings = $this->getByAccountId($accountId);

        foreach($customerSettings as $customerSetting)
        {
            $this->getPixiepadEntityManager()->remove($customerSetting);
            $this->getPixiepadEntityManager()->flush();
        }
    }

    /**
     * @param $customFields
     * @param $customerSettings
     */
    private function validateAllStored($customFields, $customerSettings)
    {
        foreach($customFields as $customField)
        {
            $control = true;
            foreach($customerSettings as $customerSetting)
            {
                if($customerSetting->getCustomFieldName() == $customField->getFieldName())
                {
                    $control = false;
                }
            }

            if($control)
            {
                self::createCustomerSettingEntry($customerSetting->getAccountId(), $customField);
            }
        }
    }

    /**
     * @param $accountId
     * @param $customField
     */
    private function createCustomerSettingEntry($accountId, $customField)
    {
        $customerSettings = new Customer();

        $label = $customField->getFieldLabel();
        if($label == null)
        {
            $label = $customField->getFieldName();
        }

        $customerSettings->setAccountId($accountId);
        $customerSettings->setCustomFieldName($customField->getFieldName());
        $customerSettings->setCustomFieldLabel($label);
        $customerSettings->setCustomFieldType($customField->getFieldType());
        $customerSettings->setCustomFieldShow("Y");
        $customerSettings->setIsAvailable(1);

        $this->getPixiepadEntityManager()->persist($customerSettings);
        $this->getPixiepadEntityManager()->flush();
    }

}