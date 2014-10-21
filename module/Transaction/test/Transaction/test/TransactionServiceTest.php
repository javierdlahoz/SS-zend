<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/20/14
 * Time: 5:48 PM
 */

namespace Transaction\Test;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use tests\Bootstrap;
use Transaction\Service\TransactionService;

error_reporting(0);

class TransactionServiceTest extends AbstractHttpControllerTestCase{

    private $transactionService;
    const ACCOUNT_ID = "Agua_Cristal";
    const CUSTOMER_CODE = '8656056326304770';
    const CAMPAIGN_ID = '8028791047981467';
    const TRANSACTION_LIMIT = 5;

    public function setUp()
    {
        parent::setUp();
        $this->transactionService = new TransactionService(Bootstrap::getServiceManager());
    }

    public function testGetThisMonthTransactions()
    {
        $transactions = $this->transactionService->getThisMonthTransactions(self::ACCOUNT_ID);
        $this->assertGreaterThanOrEqual(0, (int)$transactions);
    }

    public function testGetThisMonthTransactionsByCustomer()
    {
        $transactions = $this->transactionService->getThisMonthTransactionsByCustomer(self::CUSTOMER_CODE, self::ACCOUNT_ID);
        $this->assertGreaterThanOrEqual(0, (int)$transactions);
    }

    public function testGetLastTransactionByCustomer()
    {
        $transactions = $this->transactionService->getLastTransactionByCustomer(self::CUSTOMER_CODE, self::ACCOUNT_ID);
        $this->assertArrayHasKey('amount', $transactions[0]);
    }

    public function testGetLastTransaction()
    {
        $transactions = $this->transactionService->getLastTransaction(self::TRANSACTION_LIMIT, self::ACCOUNT_ID);
        $this->assertArrayHasKey('amount', $transactions[0]);
    }

    public function testGetByCode()
    {
        $transactions = $this->transactionService->getByCode(self::CUSTOMER_CODE, self::ACCOUNT_ID);
        foreach($transactions as $transaction)
        {
            $this->assertInstanceOf('Transaction\Entity\Transaction', $transaction);
        }
    }

    public function testGetHistoryByCodeAndCampaignId()
    {
        $transactions = $this->transactionService->getHistoryByCodeAndCampaignId(self::CUSTOMER_CODE, self::CAMPAIGN_ID, self::ACCOUNT_ID);
        foreach($transactions as $transaction)
        {
            $this->assertInstanceOf('Transaction\Entity\Transaction', $transaction);
        }
    }

    public function testGetHistoryByCode()
    {
        $transactions = $this->transactionService->getHistoryByCode(self::CUSTOMER_CODE, self::ACCOUNT_ID);
        foreach($transactions as $transaction)
        {
            $this->assertInstanceOf('Transaction\Entity\Transaction', $transaction);
        }
    }

    public function testGetCustomFields()
    {
        $customFields = $this->transactionService->getCustomFields(self::ACCOUNT_ID);
        foreach($customFields as $customField)
        {
            $this->assertInstanceOf('Transaction\Entity\Field\CustomField', $customField);
        }
    }
}