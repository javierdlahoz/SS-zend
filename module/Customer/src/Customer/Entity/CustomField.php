<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/2/14
 * Time: 2:36 PM
 */

namespace Customer\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
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
     * @return string
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

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
    public function getFieldChoices()
    {
        return $this->field_choices;
    }

    /**
     * @param string $field_choices
     */
    public function setFieldChoices($field_choices)
    {
        $this->field_choices = $field_choices;
    }

    /**
     * @return string
     */
    public function getFieldLabel()
    {
        return $this->field_label;
    }

    /**
     * @param string $field_label
     */
    public function setFieldLabel($field_label)
    {
        $this->field_label = $field_label;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->field_name;
    }

    /**
     * @param string $field_name
     */
    public function setFieldName($field_name)
    {
        $this->field_name = $field_name;
    }

    /**
     * @return string
     */
    public function getFieldShow()
    {
        return $this->field_show;
    }

    /**
     * @param string $field_show
     */
    public function setFieldShow($field_show)
    {
        $this->field_show = $field_show;
    }

    /**
     * @return string
     */
    public function getFieldType()
    {
        return $this->field_type;
    }

    /**
     * @param string $field_type
     */
    public function setFieldType($field_type)
    {
        $this->field_type = $field_type;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
} 