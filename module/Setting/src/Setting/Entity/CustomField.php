<?php

namespace Setting\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="custom_fields")
 * @ORM\Entity
 */
class CustomField
{
    /**
     * @var integer
     *
     * @ORM\Column(name="unique_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(name="account_id", type="string", nullable=true)
     * @var string
     */
    private $account_id;

    /**
     * @ORM\Column(name="field_name", type="string", nullable=true)
     * @var string
     */
    private $field_name;

    /**
     * @ORM\Column(name="field_label", type="string", nullable=true)
     * @var string
     */
    private $field_label;

    /**
     * @ORM\Column(name="field_type", type="string", nullable=true)
     * @var string
     */
    private $field_type;

    /**
     * @ORM\Column(name="field_show", type="string", nullable=true)
     * @var string
     */
    private $field_show;

    /**
     * @ORM\Column(name="field_choices", type="string", nullable=true)
     * @var string
     */
    private $field_choices;

    /**
     * @ORM\Column(name="field_unique", type="string", nullable=true)
     * @var string
     */
    private $field_unique;

    /**
     * @ORM\Column(name="field_searchable", type="string", nullable=true)
     * @var string
     */
    private $field_searchable;


    /**
     * @param string $account_id
     */
    public function setAccountId($account_id)
    {
        $this->account_id = $account_id;
    }

    /**
     * @return string
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * @param string $custom_field_choises
     */
    public function setFieldChoices($custom_field_choices)
    {
        $this->field_choices = $custom_field_choices;
    }

    /**
     * @return string
     */
    public function getFieldChoices()
    {
        return $this->field_choices;
    }

    /**
     * @param string $custom_field_label
     */
    public function setFieldLabel($custom_field_label)
    {
        $this->field_label = $custom_field_label;
    }

    /**
     * @return string
     */
    public function getFieldLabel()
    {
        return $this->field_label;
    }

    /**
     * @param string $custom_field_name
     */
    public function setFieldName($custom_field_name)
    {
        $this->field_name = $custom_field_name;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->field_name;
    }

    /**
     * @param string $custom_field_show
     */
    public function setFieldShow($custom_field_show)
    {
        $this->field_show = $custom_field_show;
    }

    /**
     * @return string
     */
    public function getFieldShow()
    {
        return $this->field_show;
    }

    /**
     * @param string $custom_field_type
     */
    public function setFieldType($custom_field_type)
    {
        $this->field_type = $custom_field_type;
    }

    /**
     * @return string
     */
    public function getFieldType()
    {
        return $this->field_type;
    }


    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $field_searchable
     */
    public function setFieldSearchable($field_searchable)
    {
        $this->field_searchable = $field_searchable;
    }

    /**
     * @return string
     */
    public function getFieldSearchable()
    {
        return $this->field_searchable;
    }

    /**
     * @param string $field_unique
     */
    public function setFieldUnique($field_unique)
    {
        $this->field_unique = $field_unique;
    }

    /**
     * @return string
     */
    public function getFieldUnique()
    {
        return $this->field_unique;
    }


}