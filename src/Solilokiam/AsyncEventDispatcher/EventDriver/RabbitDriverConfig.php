<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 21/09/14
 * Time: 18:48
 */

namespace Solilokiam\AsyncEventDispatcher\EventDriver;

class RabbitDriverConfig
{
    private $host;
    private $port;
    private $username;
    private $password;
    private $serializerFormat;
    private $maxMessageNumber;

    public function __construct()
    {
        $this->serializerFormat = 'json';
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param mixed $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
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

    /**
     * @return mixed
     */
    public function getMaxMessageNumber()
    {
        return $this->maxMessageNumber;
    }

    /**
     * @param mixed $maxMessageNumber
     */
    public function setMaxMessageNumber($maxMessageNumber)
    {
        $this->maxMessageNumber = $maxMessageNumber;
    }
}
