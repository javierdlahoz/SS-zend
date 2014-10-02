<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/12/14
 * Time: 11:33 AM
 */

namespace Customer\Entity;

use Customer\Facade\CustomFieldFacade;

class Customer{

    function __construct($SQLData = null, $customFields = null)
    {
        if($SQLData != null)
        {
            foreach($SQLData as $key => $value)
            {
                try{
                    $this->{$key} = $value;
                }
                catch(\Exception $ex)
                {
                    //nothing here
                }
            }
            $this->custom_fields = array();
            $count = 0;
            foreach($customFields as $customField)
            {
                $this->custom_fields[$count] = CustomFieldFacade::formatCustomField($customField);
                $this->custom_fields[$count]["value"] = $SQLData[$customField->getFieldName()];
                $count++;
            }
        }
    }

    private $unique_id;

    private $first_name;

    private $last_name;

    private $card_code;

    private $card_number;

    private $account_id;

    private $phone;

    private $email;

    private $custom_date;

    private $custom1;

    private $address1;

    private $address2;

    private $city;

    private $state;

    private $zip;

    private $country;

    private $custom_field_2;

    private $datetime_stamp;

    private $customer_password;

    private $customer_username;

    private $customer_PIN;

    private $custom_fields;

    /**
     * @return mixed
     */
    public function getCustomFields()
    {
        return $this->custom_fields;
    }

    /**
     * @param mixed $customFields
     */
    public function setCustomFields($customFields)
    {
        $this->custom_fields = $customFields;
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
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * @param mixed $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param mixed $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param mixed $card_code
     */
    public function setCardCode($card_code)
    {
        $this->card_code = $card_code;
    }

    /**
     * @return mixed
     */
    public function getCardCode()
    {
        return $this->card_code;
    }

    /**
     * @param mixed $card_number
     */
    public function setCardNumber($card_number)
    {
        $this->card_number = $card_number;
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->card_number;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $custom1
     */
    public function setCustom1($custom1)
    {
        $this->custom1 = $custom1;
    }

    /**
     * @return mixed
     */
    public function getCustom1()
    {
        return $this->custom1;
    }

    /**
     * @param mixed $custom_date
     */
    public function setCustomDate($custom_date)
    {
        $this->custom_date = $custom_date;
    }

    /**
     * @return mixed
     */
    public function getCustomDate()
    {
        return $this->custom_date;
    }

    /**
     * @param mixed $custom_field_2
     */
    public function setCustomField2($custom_field_2)
    {
        $this->custom_field_2 = $custom_field_2;
    }

    /**
     * @return mixed
     */
    public function getCustomField2()
    {
        return $this->custom_field_2;
    }

    /**
     * @param mixed $customer_PIN
     */
    public function setCustomerPIN($customer_PIN)
    {
        $this->customer_PIN = $customer_PIN;
    }

    /**
     * @return mixed
     */
    public function getCustomerPIN()
    {
        return $this->customer_PIN;
    }

    /**
     * @param mixed $customer_password
     */
    public function setCustomerPassword($customer_password)
    {
        $this->customer_password = $customer_password;
    }

    /**
     * @return mixed
     */
    public function getCustomerPassword()
    {
        return $this->customer_password;
    }

    /**
     * @param mixed $customer_username
     */
    public function setCustomerUsername($customer_username)
    {
        $this->customer_username = $customer_username;
    }

    /**
     * @return mixed
     */
    public function getCustomerUsername()
    {
        return $this->customer_username;
    }

    /**
     * @param mixed $datetime_stamp
     */
    public function setDatetimeStamp($datetime_stamp)
    {
        $this->datetime_stamp = $datetime_stamp;
    }

    /**
     * @return mixed
     */
    public function getDatetimeStamp()
    {
        return $this->datetime_stamp;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $unique_id
     */
    public function setUniqueId($unique_id)
    {
        $this->unique_id = $unique_id;
    }

    /**
     * @return mixed
     */
    public function getUniqueId()
    {
        return $this->unique_id;
    }

    /**
     * @param mixed $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param $post
     */
    public function fillFromPost($post, $customFields = null)
    {
        if($post->get('firstName') != null){
            $this->first_name = $post->get('firstName');
        }

        if($post->get('lastName') != null){
            $this->last_name = $post->get('lastName');
        }

        if($post->get('cardCode') != null){
            $this->card_code = $post->get('cardCode');
        }

        if($post->get('cardNumber') != null){
            $this->card_number = $post->get('cardNumber');
        }

        if($post->get('phone') != null){
            $this->phone = $post->get('phone');
        }

        if($post->get('email') != null){
            $this->email = $post->get('email');
        }

        if($post->get('address1') != null){
            $this->address1 = $post->get('address1');
        }

        if($post->get('address2') != null){
            $this->address2 = $post->get('address2');
        }

        if($post->get('city') != null){
            $this->city = $post->get('city');
        }

        if($post->get('state') != null){
            $this->state = $post->get('state');
        }

        if($post->get('zip') != null){
            $this->zip = $post->get('zip');
        }

        if($post->get('country') != null){
            $this->country = $post->get('country');
        }

        if($customFields != null)
        {
            $count = 0;
            $this->custom_fields = array();
            foreach($customFields as $customField)
            {
                $this->custom_fields[$count] = CustomFieldFacade::formatCustomField($customField);
                if($post->get($customField->getFieldName()) != null)
                {
                    $this->custom_fields[$count]["value"] = $post->get($customField->getFieldName());
                }
                else
                {
                    $this->custom_fields[$count]["value"] = null;
                }
                $count++;
            }
        }
    }

} 