<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 30/10/14
 * Time: 21:01
 */

namespace Solilokiam\AsyncEventDispatcher\EventDriver;


class RedisDriverConfig
{
    protected $host;
    protected $port;
    protected $database;
    protected $password;
    protected $keyPrefix;
    protected $serializerFormat;

    function __construct()
    {
        $this->serializerFormat = 'json';
    }


    /**
     * @param mixed $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    /**
     * @param mixed $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getKeyPrefix()
    {
        return $this->keyPrefix;
    }

    /**
     * @param mixed $keyPrefix
     */
    public function setKeyPrefix($keyPrefix)
    {
        $this->keyPrefix = $keyPrefix;
    }

    /**
     * @return mixed
     */
    public function getSerializerFormat()
    {
        return $this->serializerFormat;
    }

    /**
     * @param mixed $serializerFormat
     */
    public function setSerializerFormat($serializerFormat)
    {
        $this->serializerFormat = $serializerFormat;
    }

    public function getConnectionConfigArray()
    {
        $configArray = array();

        if ($this->host !== null) {
            $configArray['host'] = $this->host;
        }

        if ($this->port !== null) {
            $configArray['port'] = $this->port;
        }

        if ($this->database !== null) {
            $configArray['database'] = $this->database;
        }

        if ($this->password !== null) {
            $configArray['password'] = $this->password;
        }

        return $configArray;
    }
} 