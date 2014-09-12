<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/4/14
 * Time: 3:20 PM
 */

namespace Application\Service;

use Application\Helper\DateHelper;

class AbstractService
{
    protected $serviceLocator;
    protected $dbSettings;
    protected $connection;
    protected $entity;
    protected $accountId;
    protected $dates;

    const PROFILE = "profiles_";
    const VISIT = "visits_";
    const LIMIT = 10;

    /**
     * @param $serviceLocator
     */
    function __construct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->prepareDbSettings();
        $this->dates = new DateHelper();
    }

    /**
     * @return mixed
     */
    protected function getConfig()
    {
        return $this->getServiceLocator()->get("Config");
    }

    /**
     * prepares DB settings
     */
    protected function prepareDbSettings()
    {
        $config  = $this->getConfig();
        $this->dbSettings = $config['doctrine']['connection']['orm_default']['params'];
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
    public function getDbSettings()
    {
        return $this->dbSettings;
    }

    /**
     * @return \mysqli
     * @throws \Exception
     */
    protected function connect()
    {
        $this->connection = mysqli_connect(
            $this->dbSettings['host'],
            $this->dbSettings['user'],
            $this->dbSettings['password'],
            $this->dbSettings['dbname'],
            $this->dbSettings['port']
        );

        if(mysqli_connect_errno())
        {
            throw new \Exception("Failed to connect to MySQL");
        }

        return $this->connection;
    }

    /**
     * disconnect mysql
     */
    protected function disconnect()
    {
        mysqli_close($this->connection);
    }

    /**
     * @param mixed $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
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
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $accountId
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        if(empty($this->accountId))
        {
            $this->accountId = $this->getAccountIdFromEntityName();
        }
        return $this->accountId;
    }

    /**
     * @return \Application\Helper\DateHelper
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @param $query
     * @return mysqli_result
     * @throws \Exception
     */
    protected function executeQuery($query)
    {
        $this->connect();
        $result = mysqli_query($this->connection, $query);
        $this->disconnect();

        if($result)
        {
            return $result;
        }
        else
        {
            throw new \Exception(mysqli_error($this->connection));
        }
    }

    /**
     * @param $query
     * @return mysqli_result
     */
    protected function count($query)
    {
        $this->validate();
        $sql = "SELECT COUNT(*) FROM ";
        $sql .= $this->entity." ";
        $sql .= $query;

        $result = $this->executeQuery($sql)->fetch_row();
        return $result[0];
    }

    /**
     * @param string $fields
     * @param $query
     * @param null $entities
     * @return mysqli_result
     */
    protected function select($fields = '*', $query, $entities = null)
    {
        $sql = "SELECT ".$fields." FROM ";

        if($entities == null)
        {
            $this->validate();
            $sql .= $this->entity." ";
        }
        else
        {
            $sql .= $entities." ";
        }
        $sql .= $query;

        $result = $this->executeQuery($sql);
        $result = $this->toArray($result);
        return $result;
    }

    protected function validate()
    {
        if(empty($this->entity))
        {
            throw new \Exception("Please select an entity");
        }
    }

    protected function toArray($result)
    {
        $results = array();
        while($row = $result->fetch_array())
        {
            array_push($results, $row);
        }
        return $results;
    }

    protected function getAccountIdFromEntityName()
    {

        $nameStringArray = explode(self::PROFILE, $this->entity);

        if(count($nameStringArray)>1)
        {
            return $nameStringArray[1];
        }
        else
        {
            $nameStringArray = explode(self::VISIT, $this->entity);
            if(count($nameStringArray)>1)
            {
                return $nameStringArray[1];
            }
            else
            {
                return null;
            }
        }
    }

    protected function getEntityNames()
    {
        $accountId = $this->getAccountId();
        $profileEntity = self::PROFILE.$accountId;
        $visitEntity = self::VISIT.$accountId;

        return array(
            "profiles" => $profileEntity,
            "visits" => $visitEntity
        );
    }

    protected function insert($abstracObject)
    {
        $query = "INSERT INTO {$this->getEntity()} ";
        $fields = "";
        $values = "";

        $isFirst = true;
        foreach($abstracObject as $key => $value)
        {
            if($isFirst)
            {
                $fields = $key;
                $values = "'{$value}'";
                $isFirst = false;
            }
            else
            {
                $fields .= ", ".$key;
                $values .= ", '{$value}'";
            }
        }

        $query .= "(".$fields.") VALUES (".$values.")";
        try
        {
            $this->executeQuery($query);
        }
        catch(\Exception $ex)
        {
            throw new \Exception($ex->getMessage());
        }

    }

}