<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/6/14
 * Time: 9:22 AM
 */

namespace Setting\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="823542_pixiedev.lp_user_campaign_settings")
 * @ORM\Entity
 */
class CampaignSettings {

    /**
     * @var bigint
     *
     * @ORM\Column(name="campaign_id", type="bigint", nullable=false)
     * @ORM\Id
     */
    private $campaign_id;

    /**
     * @var string
     *
     * @ORM\Column(name="field_name", type="string", nullable=false)
     * @ORM\Id
     */
    private $field_name;

    /**
     * @var string
     * @ORM\Column(name="field_label", type="string", nullable=false)
     */
    private $field_label;

    /**
     * @var integer
     * @ORM\Column(name="is_active", type="integer", nullable=false)
     */
    private $is_active;

    /**
     * @return int
     */
    public function getCampaignId()
    {
        return $this->campaign_id;
    }

    /**
     * @param int $campaign_id
     */
    public function setCampaignId($campaign_id)
    {
        $this->campaign_id = $campaign_id;
    }

    /**
     * @return mixed
     */
    public function getFieldLabel()
    {
        return $this->field_label;
    }

    /**
     * @param mixed $field_label
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
     * @return int
     */
    public function getIsActive()
    {
        if($this->is_active == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param int $is_active
     */
    public function setIsActive($is_active)
    {
        if($is_active == true)
        {
            $this->is_active = 1;
        }
        else
        {
            $this->is_active = 0;
        }
    }


} 