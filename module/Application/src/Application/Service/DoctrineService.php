<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/9/14
 * Time: 9:20 AM
 */

namespace Application\Service;

abstract class DoctrineService
{
    private $serviceLocator;
    private $entity;

    /**
     * @return mixed
     */
    public function getPixiepadEntityManager()
    {

        return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }

    function __construct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->init();
    }

    /**
     * @param mixed $serviceLocator
     */
    protected function setServiceLocator($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return mixed
     */
    protected function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @return mixed
     */
    protected function getEntityManager()
    {
        return $this->getServiceLocator()->get('doctrine.entitymanager.orm_stickystreet');
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    protected function getEntity()
    {
        return $this->entity;
    }

    public abstract function init();

}