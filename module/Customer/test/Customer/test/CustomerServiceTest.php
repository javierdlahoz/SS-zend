<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/20/14
 * Time: 5:48 PM
 */

namespace Customer\Test;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use tests\Bootstrap;
use Customer\Service\CustomerService;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;
use User\Entity\User;

error_reporting(0);

class CustomerServiceTest extends AbstractHttpControllerTestCase{

    private $customerService;
    private $request;

    const ACCOUNT_ID = "Agua_Cristal";
    const TEXT_TO_LOOK_FOR = "a";
    const CUSTOMER_CODE = '8656056326304770';
    const CAMPAIGN_ID = '8028791047981467';
    const CUSTOMER_LIMIT = 5;
    const ENTITY = "profiles_agua_cristal";

    const FIRST_NAME = "Eusebio";
    const LAST_NAME = "EusebioMan";
    const NEW_LAST_NAME = "MozidoTestingMan";

    public function setUp()
    {
        parent::setUp();
        $this->customerService = new CustomerService(Bootstrap::getServiceManager());
        $this->customerService->setAccountId(self::ACCOUNT_ID);
        $this->customerService->setEntity(self::ENTITY);

        $this->request = new Request();
        $this->request->setMethod("POST");
    }

    public function testGetCustomerCount()
    {
        $customersCount = $this->customerService->getCustomerCount();
        $this->assertGreaterThanOrEqual(0, (int)$customersCount);
    }

    public function testGetMostActive()
    {
        $customers = $this->customerService->getMostActive(self::ACCOUNT_ID);
        foreach($customers as $customer)
        {
            $this->assertArrayHasKey('code', $customer);
        }
    }

    public function testGetCustomerByCode()
    {
        $customer = $this->customerService->getCustomerByCode(self::CUSTOMER_CODE, self::ACCOUNT_ID);
        $this->assertArrayHasKey('card_number', $customer);
    }

    public function testGetCustomersThisMonth()
    {
        $customerCount = $this->customerService->getCustomersThisMonth(self::ACCOUNT_ID);
        $this->assertGreaterThanOrEqual(0, (int)$customerCount);
    }

    public function testGetLastCustomers()
    {
        $customers = $this->customerService->getLastCustomers(self::CUSTOMER_LIMIT, self::ACCOUNT_ID);
        $this->assertArrayHasKey('card_number', $customers[0]);
    }

    public function testGetByText()
    {
        $customers = $this->customerService->getByText(self::TEXT_TO_LOOK_FOR, self::ACCOUNT_ID);
        $this->assertInstanceOf('Customer\Entity\Customer', $customers[0]);
    }

    public function testAddCustomer()
    {
        $user = new User();
        $user->setAccount(self::ACCOUNT_ID);

        $parameters = new Parameters(array("firstName" => self::FIRST_NAME, "lastName" => self::LAST_NAME));
        $this->request->setPost($parameters);

        $this->customerService->add($this->request->getPost(), $user);
        $customers = $this->customerService->getByText(self::LAST_NAME, self::ACCOUNT_ID);

        $this->assertEquals($customers[0]->getLastName(), self::LAST_NAME);
    }

    public function testEditCustomer()
    {
        $customers = $this->customerService->getByText(self::LAST_NAME, self::ACCOUNT_ID);
        $customer = $customers[0];
        $customer->setLastName(self::NEW_LAST_NAME);

        $this->customerService->editCustomer($customer, self::ACCOUNT_ID);
        $customers = $this->customerService->getByText(self::NEW_LAST_NAME, self::ACCOUNT_ID);

        $this->assertEquals($customers[0]->getLastName(), self::NEW_LAST_NAME);
    }

    public function testDeleteCustomer()
    {
        $customers = $this->customerService->getByText(self::NEW_LAST_NAME, self::ACCOUNT_ID);
        $this->customerService->deleteCustomer($customers[0], self::ACCOUNT_ID);

        $customers = $this->customerService->getByText(self::NEW_LAST_NAME, self::ACCOUNT_ID);

        $this->assertNull($customers);
    }

}