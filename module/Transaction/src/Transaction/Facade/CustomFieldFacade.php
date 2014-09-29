<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/22/14
 * Time: 3:49 PM
 */

namespace Transaction\Facade;

use Transaction\Entity\Field\CustomField;

class CustomFieldFacade {

    /**
     * @param CustomField $customField
     * @return array
     */
    public function formatCustomField(CustomField $customField)
    {
        return array(
            'id' => $customField->getId(),
            'name' => $customField->getName(),
            'label' => $customField->getLabel(),
            'type' => $customField->getType(),
            'choices' => $customField->getChoices()
        );
    }

    /**
     * @param $customFieldCollection
     * @return array
     */
    public function formatCustomFieldCollection($customFieldCollection)
    {
        foreach($customFieldCollection as $customField)
        {
            $customFields[] = self::formatCustomField($customField);
        }

        return $customFields;
    }
} 