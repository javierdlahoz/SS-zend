<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/22/14
 * Time: 3:32 PM
 */
namespace Transaction\Entity\Field;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table(name="custom_transaction_fields")
 * @ORM\Entity
 */
class CustomField {

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
    private $name;

    /**
     * @ORM\Column(name="field_label", type="string", nullable=true)
     * @var string
     */
    private $label;

    /**
     * @ORM\Column(name="field_type", type="string", nullable=true)
     * @var string
     */
    private $type;

    /**
     * @ORM\Column(name="field_show", type="string", nullable=true)
     * @var string
     */
    private $is_shown;

    /**
     * @ORM\Column(name="field_choices", type="string", nullable=true)
     * @var string
     */
    private $choices;

    /**
     * @ORM\Column(name="field_unique", type="string", nullable=true)
     * @var string
     */
    private $isUnique;

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * @param mixed $account_id
     */
    public function setAccountId($account_id)
    {
        $this->account_id = $account_id;
    }

    /**
     * @return mixed
     */
    public function getChoices()
    {
        if(!empty($this->choices))
        {
            $choices = explode(',', $this->choices);
            return $choices;
        }
        else
        {
            return null;
        }
    }

    /**
     * @param mixed $choices
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIsShown()
    {
        if($this->is_shown == "Y")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param mixed $isShown
     */
    public function setIsShown($isShown)
    {
        if($isShown == true)
        {
            $this->is_shown = "Y";
        }
        else
        {
            $this->is_shown = "N";
        }
    }

    /**
     * @return mixed
     */
    public function getIsUnique()
    {
        if($this->isUnique == "Y")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param mixed $isUnique
     */
    public function setIsUnique($isUnique)
    {
        if($isUnique == true)
        {
            $this->isUnique = "Y";
        }
        else
        {
            $this->isUnique = "N";
        }
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
} 