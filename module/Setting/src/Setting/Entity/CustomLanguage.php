<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/9/14
 * Time: 11:57 AM
 */

namespace Setting\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="lp_customlanguage")
 * @ORM\Entity
 */
class CustomLanguage {

    /**
     * @var string
     *
     * @ORM\Column(name="account_id", type="string", nullable=false)
     * @ORM\Id
     */
    private $account_id;

    /**
     * @var string
     * @ORM\Column(name="custom_language", type="string", nullable=false)
     */
    private $custom_language;

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
    public function getCustomLanguage()
    {
        return $this->custom_language;
    }

    /**
     * @param string $custom_language
     */
    public function setCustomLanguage($custom_language)
    {
        $this->custom_language = $custom_language;
    }
} 