<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/5/14
 * Time: 9:04 AM
 */

namespace Setting\Facade;

use Setting\Entity\Customer;
use Setting\Entity\CustomField;

class CustomerSettingFacade
{
    /**
     * @param $customerSettings
     * @return array
     */
    public function formatCustomerSettings($customerSettings)
    {
         foreach($customerSettings as $customerSetting)
         {
             if($customerSetting instanceof Customer)
             {
                 if($customerSetting->getCustomFieldShow() == "Y")
                 {
                     $customFieldShow = true;
                 }
                 else
                 {
                     $customFieldShow = false;
                 }

                 $results[] = array(
                     "custom_field_name" => $customerSetting->getCustomFieldName(),
                     "custom_field_label" => $customerSetting->getCustomFieldLabel(),
                     "custom_field_type" => $customerSetting->getCustomFieldType(),
                     "custom_field_show" => $customFieldShow,
                     "custom_field_choices" => $customerSetting->getCustomFieldChoices(),
                     "is_available" => $customerSetting->getIsAvailable()
                 );
             }
             else
             {
                 if($customerSetting->getFieldShow() == "Y")
                 {
                     $customFieldShow = true;
                 }
                 else
                 {
                     $customFieldShow = false;
                 }

                 $results[] = array(
                     "custom_field_name" => $customerSetting->getFieldName(),
                     "custom_field_label" => $customerSetting->getFieldLabel(),
                     "custom_field_type" => $customerSetting->getFieldType(),
                     "custom_field_show" => $customFieldShow,
                     "custom_field_choices" => $customerSetting->getFieldChoices(),
                     "is_available" => true
                 );
             }

         }

        return $results;
    }

    /**
     * @param $customFields
     * @return array
     */
    public function formatCustomFields($customFields)
    {
        $formattedCustomFields = array();
        foreach($customFields as $customField)
        {
            $formattedCustomFields[$customField->getFieldName()] = $customField->getFieldLabel();
        }

        return $formattedCustomFields;
    }
}