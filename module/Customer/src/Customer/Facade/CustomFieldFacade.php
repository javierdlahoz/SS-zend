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
     * @param $choices
     * @return array
     */
    private function formatChoices($choices)
    {
        if($choices == null)
        {
            return null;
        }

        $choicesTmp = explode(",", $choices);
        return $choicesTmp;
    }

    /**
     * @param CustomField $customField
     * @return array
     */
    public function formatCustomField(CustomField $customField)
    {
        $label = $customField->getFieldLabel();
        if($label == null)
        {
            $label = $customField->getFieldName();
        }

        return array(
            "id" => $customField->getId(),
            "name" => $customField->getFieldName(),
            "label" => $label,
            "type" => $customField->getFieldType(),
            "choices" => self::formatChoices($customField->getFieldChoices()),
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