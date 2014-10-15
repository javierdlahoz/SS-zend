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

class CustomerSettingService extends DoctrineService
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
        $customFieldEntity =  $this->getPixiepadEntityManager()->getRepository(self::ENTITY_CUSTOM_FIELDS);
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
        return $this->getEntity()->findBy(array('account_id' => $accountId));
    }

    /**
     * @param $accountId
     */
    public function createByAccountId($accountId)
    {
        $customerFields = $this->getAllFields();
        /*$customerFields = array_merge($customerFields,
            CustomerSettingFacade::formatCustomFields($this->getCustomFields($accountId)));
        */

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

            $this->getPixiepadEntityManager()->persist($customerSettings);
            $this->getPixiepadEntityManager()->flush();
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

}