<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/5/14
 * Time: 9:04 AM
 */

namespace Customer\Facade;
use Customer\Entity\Customer;

class CustomerFacade
{
    public function getCustomerData($customer)
    {
        return array(
            "name" => $customer['first_name']." ".$customer['last_name'],
            "email" => $customer['email'],
            "cardNumber" => $customer['card_number']
        );
    }

    public function formatLastCustomers($lastCustomersSQLResult)
    {
        foreach($lastCustomersSQLResult as $customer)
        {
            $lastCustomers[] = self::getCustomerData($customer);
        }
        return $lastCustomers;
    }

    /**
     * @param $customer
     * @return array
     */
    public function formatCustomerEntity($customer)
    {
        return array(
            "id"        => $customer->getUniqueId(),
            "firstName" => $customer->getFirstName(),
            "lastName"  => $customer->getLastName(),
            "cardCode"  => $customer->getCardCode(),
            "CardNumber" => $customer->getCardNumber(),
            "phone"     => $customer->getPhone(),
            "email"     => $customer->getEmail(),
            "city"      => $customer->getCity(),
            "state"     => $customer->getState(),
            "country"   => $customer->getCountry(),
            "address1"  => $customer->getAddress1(),
            "address2"  => $customer->getAddress2()
        );
    }

    public function formatCustomerCollection($customers)
    {
        foreach($customers as $customer)
        {
            $customerCollection[] = self::formatCustomerEntity($customer);
        }
        return $customerCollection;
    }
}