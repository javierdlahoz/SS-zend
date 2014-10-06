<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/11/14
 * Time: 3:48 PM
 */

namespace Setting\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="823542_pixiedev.lp_customfields")
 * @ORM\Entity
 */
class Customer
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
     * @ORM\Column(name="custom_field_name", type="string", nullable=true)
     * @var string
     */
    private $custom_field_name;

    /**
     * @ORM\Column(name="custom_field_label", type="string", nullable=true)
     * @var string
     */
    private $custom_field_label;

    /**
     * @ORM\Column(name="custom_field_type", type="string", nullable=true)
     * @var string
     */
    private $custom_field_type;

    /**
     * @ORM\Column(name="custom_field_show", type="string", nullable=true)
     * @var string
     */
    private $custom_field_show;

    /**
     * @ORM\Column(name="custom_field_choices", type="string", nullable=true)
     * @var string
     */
    private $custom_field_choices;

    /**
     * @ORM\Column(name="is_available", type="boolean", nullable=true)
     * @var string
     */
    private $is_available;

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
    public function setCustomFieldChoices($custom_field_choices)
    {
        $this->custom_field_choices = $custom_field_choices;
    }

    /**
     * @return string
     */
    public function getCustomFieldChoices()
    {
        return $this->custom_field_choices;
    }

    /**
     * @param string $custom_field_label
     */
    public function setCustomFieldLabel($custom_field_label)
    {
        $this->custom_field_label = $custom_field_label;
    }

    /**
     * @return string
     */
    public function getCustomFieldLabel()
    {
        return $this->custom_field_label;
    }

    /**
     * @param string $custom_field_name
     */
    public function setCustomFieldName($custom_field_name)
    {
        $this->custom_field_name = $custom_field_name;
    }

    /**
     * @return string
     */
    public function getCustomFieldName()
    {
        return $this->custom_field_name;
    }

    /**
     * @param string $custom_field_show
     */
    public function setCustomFieldShow($custom_field_show)
    {
        $this->custom_field_show = $custom_field_show;
    }

    /**
     * @return string
     */
    public function getCustomFieldShow()
    {
        return $this->custom_field_show;
    }

    /**
     * @param string $custom_field_type
     */
    public function setCustomFieldType($custom_field_type)
    {
        $this->custom_field_type = $custom_field_type;
    }

    /**
     * @return string
     */
    public function getCustomFieldType()
    {
        return $this->custom_field_type;
    }

    /**
     * @param string $is_available
     */
    public function setIsAvailable($is_available)
    {
        $this->is_available = $is_available;
    }

    /**
     * @return string
     */
    public function getIsAvailable()
    {
        return $this->is_available;
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

}