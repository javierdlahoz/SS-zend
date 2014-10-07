<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/4/14
 * Time: 3:18 PM
 */

namespace Customer\Service;

use Application\Service\AbstractService;
use Customer\Entity\Customer;


class CustomerService extends AbstractService
{
    const FIELDS = "first_name, last_name, email, card_number";

    /**
     * @return \Application\Service\mysqli_result
     */
    public function getCustomerCount()
    {
        $count = $this->count(null);
        return $count;
    }

    /**
     * @param $accountId
     * @return \Application\Service\mysqli_result
     */
    public function getMostActive($accountId)
    {
        $this->setEntity(self::VISIT.$accountId);
        $fields = "code, COUNT(*) as times";
        $query = "GROUP BY code ORDER BY times DESC LIMIT ".self::LIMIT;
        $results = $this->select($fields, $query);

        return $results;
    }

    /**
     * @param $code
     * @param $accountId
     * @return mixed
     */
    public function getCustomerByCode($code, $accountId)
    {
        $this->setEntity(self::PROFILE.$accountId);
        $query = "WHERE card_code = '{$code}'";
        $results = $this->select(self::FIELDS, $query);

        return $results[0];
    }

    /**
     * @param $accountId
     * @return \Application\Service\mysqli_result
     */
    public function getCustomersThisMonth($accountId)
    {
        $this->setEntity(self::PROFILE.$accountId);
        $query = "WHERE datetime_stamp >= '{$this->getDates()->getStartDate()}' AND datetime_stamp <= '{$this->getDates()->getEndDate()}'";

        return $this->count($query);
    }

    /**
     * @param $customerNumber
     * @param $accountId
     * @return \Application\Service\mysqli_result
     */
    public function getLastCustomers($customerNumber, $accountId)
    {
        $this->setEntity(self::PROFILE.$accountId);
        $query = "ORDER BY datetime_stamp DESC LIMIT ".$customerNumber;

        return $this->select(self::FIELDS, $query);
    }

    /**
     * @param $text
     * @param $accountId
     * @return array
     */
    public function getByText($text, $accountId)
    {
        $this->setEntity(self::PROFILE.$accountId);
        $query = "WHERE first_name LIKE '%{$text}%' OR last_name LIKE '%{$text}%' OR card_code LIKE '%{$text}%'";
        $query .= " OR card_number LIKE '%{$text}%' OR phone LIKE '%{$text}%' OR email LIKE '%{$text}%'";

        $sqlResults = $this->select("*", $query);
        foreach($sqlResults as $sqlResult)
        {
            $customers[] = new Customer($sqlResult, self::getCustomFields($accountId));
        }

        return $customers;
    }

    /**
     * @param $post
     * @param $accountId
     * @throws \Exception
     */
    public function add($post, $user)
    {
        $this->setEntity(self::PROFILE.$user->getAccount());

        $customerArray = array(
            "first_name" => $post->get('firstName'),
            "last_name" => $post->get('lastName'),
            "email" => $post->get('email'),
            "phone" => $post->get('phone'),
            "card_number" => $post->get('cardNumber'),
            "city"      => $post->get('city'),
            "state"     => $post->get('state'),
            "country"   => $post->get('country'),
            "address1"  => $post->get('address1'),
            "address2"  => $post->get('address2')
        );

        $customFields = self::getCustomFields($user->getAccount());
        foreach($customFields as $customField)
        {
            $customerArray[$customField->getFieldName()] = $post->get($customField->getFieldName());
        }

        $customerAdapter = $this->getServiceLocator()->get('customerAdapter');
        $customerAdapter->setUser($user);
        $customerAdapter->add($customerArray);
    }

    /**
     * @param Customer $customer
     * @param $accountId
     * @throws \Exception
     */
    public function editCustomer(Customer $customer, $accountId)
    {
        $this->setEntity(self::PROFILE.$accountId);

        if($customer instanceof Customer)
        {
            $customerArray = array(
                "first_name" => $customer->getFirstName(),
                "last_name" => $customer->getLastName(),
                "email" => $customer->getEmail(),
                "phone" => $customer->getPhone(),
                "card_number" => $customer->getCardNumber(),
                "city"      => $customer->getCity(),
                "state"     => $customer->getState(),
                "country"   => $customer->getCountry(),
                "address1"  => $customer->getAddress1(),
                "address2"  => $customer->getAddress2()
            );

            $customFields = $customer->getCustomFields();
            if(count($customFields)>0)
            {
                foreach ($customFields as $customField)
                {
                    $customerArray[$customField['name']] = $customField['value'];
                }
            }

            $where = array('card_code' => $customer->getCardCode());
            $this->edit($customerArray, $where);
        }
        else
        {
            throw new \Exception('Bad Request');
        }
    }

    /**
     * @param $accountId
     * @return mixed
     */
    public function getCustomFields($accountId)
    {
        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $customFields = $entityManager->getRepository('Customer\Entity\CustomField')
            ->findBy(array('account_id' => $accountId));

        return $customFields;
    }
}