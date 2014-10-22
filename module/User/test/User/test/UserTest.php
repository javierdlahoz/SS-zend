<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/20/14
 * Time: 5:48 PM
 */

namespace User\Test;

use User\Auth\LoginAdapter;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use tests\Bootstrap;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;
use User\Entity\User;

error_reporting(0);

class UserTest extends AbstractHttpControllerTestCase{

    private $loginAdapter;
    private $request;

    const USERNAME = "biscuit";
    const PASSWORD = "biscuit";
    const PIN = 7777;
    const ACCOUNT_ID = "salongeeks";

    public function setUp()
    {
        parent::setUp();
        $this->loginAdapter = new LoginAdapter(Bootstrap::getServiceManager());
        $this->request = new Request();
        $this->request->setMethod("POST");
    }

    public function testLoginWithCredentials()
    {
        $parameters = new Parameters(array("username" => self::USERNAME, "password" => self::PASSWORD));
        $this->request->setPost($parameters);

        $user = $this->loginAdapter->login($this->request->getPost());
        $this->assertInstanceOf('User\Entity\User', $user);
    }

    public function testLoginWithPIN()
    {
        $parameters = new Parameters(array("pin" => self::PIN, "accountId" => self::ACCOUNT_ID));
        $this->request->setPost($parameters);

        $user = $this->loginAdapter->login($this->request->getPost());
        $this->assertInstanceOf('User\Entity\User', $user);

    }

} 