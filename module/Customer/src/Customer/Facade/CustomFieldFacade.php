<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/2/14
 * Time: 2:42 PM
 */

namespace Customer\Facade;

use Customer\Entity\CustomField;

class CustomFieldFacade {

    /**
     * @param CustomField $customField
     * @return array
     */
    public function formatCustomField(CustomField $customField)
    {
        return array(
            "id" => $customField->getId(),
            "name" => $customField->getFieldName(),
            "label" => $customField->getFieldLabel(),
            "type" => $customField->getFieldType(),
            "choices" => $customField->getFieldChoices(),
            "isShown" => $customField->getFieldShow()
        );
    }

    /**
     * @param $customFieldCollection
     * @return array|null
     */
    public function formatCustomFieldCollection($customFieldCollection)
    {
        if(empty($customFieldCollection))
        {
            return null;
        }
        else
        {
            foreach($customFieldCollection as $customField)
            {
                $customFields[] = self::formatCustomField($customField);
            }
            return $customFields;
        }
    }
} 