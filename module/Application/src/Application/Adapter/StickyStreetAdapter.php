<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/16/14
 * Time: 11:59 AM
 */

namespace Application\Adapter;

use Zend\Http\Client;
use Zend\Http\Request;

abstract class StickyStreetAdapter {

    protected $config;
    protected $serviceLocator;
    protected $ssClient;
    protected $params;
    protected $user;

    const API_VERSION = "1.5";


    function __construct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $config = $this->getServiceLocator()->get("Config");
        $this->config = $config['stickystreet'];

        $this->ssClient = new Client($this->config['url']);
        $this->ssClient->setMethod(Request::METHOD_POST);

    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $serviceLocator
     */
    public function setServiceLocator($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return mixed
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $ssClient
     */
    public function setSsClient($ssClient)
    {
        $this->ssClient = $ssClient;
    }

    /**
     * @return mixed
     */
    public function getSsClient()
    {
        return $this->ssClient;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param null $params
     * @param bool $hasResponse
     * @throws \Exception
     * @return bool
     */
    protected function sendRequest($params = null, $hasResponse = false)
    {
        if($params == null)
        {
            $this->ssClient->setParameterPost($this->getParams());
        }
        else
        {
            $this->ssClient->setParameterPost($params);
        }

        $response = $this->ssClient->send();
        $this->setParams(null);

        if($response->isSuccess())
        {
            if($hasResponse)
            {
                return json_decode($response->getBody(), true);
            }
            else
            {
                return true;
            }
        }
        else
        {
            throw new \Exception($response->getBody());
        }
    }

    /**
     * @param $customerCode
     * @param $campaignId
     * @param null $authorization
     */
    protected function prepareParams($customerCode = null, $campaignId = null, $authorization = null)
    {
        $apiCredentials = $this->getServiceLocator()->get('userHelper')->getApiCredentials($this->user);

        $this->setParams(array(
            'user_id' => $apiCredentials['accountId'],
            'user_password' => $apiCredentials['token'],
            'account_id' => $apiCredentials['accountId'],
            'code' => $customerCode,
            'campaign_id' => $campaignId,
            'authorization' => $authorization,
            'output' => "JSON"
        ));
    }
} 