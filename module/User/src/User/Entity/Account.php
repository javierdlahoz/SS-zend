<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * User
 *
 * @ORM\Table(name="accounts")
 * @ORM\Entity
 */
class Account
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
     * @ORM\Column(name="account_id", type="string", nullable=false)
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $account_id;

    /**
     * @ORM\Column(name="account_password", type="string", nullable=false)
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="string", name="biz_name", nullable=false)
     * @var string
     */
    private $name;


    /**
     * @param string $accountId
     */
    public function setAccountId($accountId)
    {
        $this->account_id = $accountId;
    }

    /**
     * @return string
     */
    public function getAccountId()
    {
        return $this->username;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}