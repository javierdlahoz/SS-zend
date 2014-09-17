<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/3/14
 * Time: 12:15 PM
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="account_users")
 * @ORM\Entity
 */
class AccountUser
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
     * @ORM\Column(name="user_name", type="string", nullable=false)
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(name="account_id", type="string", nullable=false)
     * @var string
     */
    private $account_id;

    /**
     * @ORM\Column(name="user_password", type="string", nullable=false)
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="string", name="user_first_name", nullable=false)
     * @var string
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", name="user_last_name", nullable=false)
     * @var string
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", name="user_deleted", nullable=false)
     * @var string
     */
    private $user_deleted;

    /**
     * @ORM\Column(type="integer", name="user_pin", nullable=false)
     * @var integer
     */
    private $user_pin;

    /**
     * @ORM\Column(type="string", name="user_role", nullable=false)
     * @var string
     */
    private $role;

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
        return $this->account_id;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
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

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $user_deleted
     */
    public function setUserDeleted($user_deleted)
    {
        $this->user_deleted = $user_deleted;
    }

    /**
     * @return string
     */
    public function getUserDeleted()
    {
        return $this->user_deleted;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param int $user_pin
     */
    public function setUserPin($user_pin)
    {
        $this->user_pin = $user_pin;
    }

    /**
     * @return int
     */
    public function getUserPin()
    {
        return $this->user_pin;
    }

    /**
     * @return string
     */
    public function getApiToken()
    {
        return sha1($this->getPassword());
    }

}