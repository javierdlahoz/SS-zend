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

class CustomerSettingService extends DoctrineService
{
    const ENTITY_NAME = 'Setting\Entity\Customer';
    const ENTITY_CUSTOM_FIELDS = 'Setting\Entity\CustomField';

    public function init()
    {
        $entityManager = $this->getEntityManager();
        try{
            $this->setEntity($entityManager->getRepository(self::ENTITY_NAME));
        }
        catch(\Exception $ex)
        {
            throw new \Exception($ex->getMessage());
        }
    }

    private function getCustomFields($accountId)
    {
        $customFieldEntity =  $this->getEntityManager()->getRepository(self::ENTITY_CUSTOM_FIELDS);
        $customFields = $customFieldEntity->findBy(array('account_id' => $accountId));

        return $customFields;
    }

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

    public function getByAccountId($accountId)
    {
        return $this->getEntity()->findBy(array('account_id' => $accountId));
    }

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

            $this->getEntityManager()->persist($customerSettings);
            $this->getEntityManager()->flush();
        }

        $customFields = $this->getCustomFields($accountId);
        foreach($customFields as $customField)
        {
            $customerSettings = new Customer();

            $customerSettings->setAccountId($accountId);
            $customerSettings->setCustomFieldName($customField->getFieldName());
            $customerSettings->setCustomFieldLabel($customField->getFieldLabel());
            $customerSettings->setCustomFieldType($customField->getFieldType());
            $customerSettings->setCustomFieldShow("Y");
            $customerSettings->setIsAvailable(1);

            $this->getEntityManager()->persist($customerSettings);
            $this->getEntityManager()->flush();
        }

    }

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
                $this->getEntityManager()->merge($customerSetting);
                $this->getEntityManager()->flush();
            }
            catch(\Exception $ex)
            {
                throw new \Exception("Something failed");
                return false;
            }
        }
        return true;
    }

}