<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 15/11/14
 * Time: 18:14
 */

namespace Solilokiam\AsyncEventDispatcher\EventDriver;


/**
 * Class AsyncEventMessage
 * @package Solilokiam\AsyncEventDispatcher\EventDriver
 */
class AsyncEventMessage
{
    /**
     * @var string
     */
    protected $eventClassName;

    /**
     * @var mixed
     */
    protected $messagePlayload;

    /**
     * @param $eventClassName
     * @param $messagePlayload
     */
    function __construct($eventClassName, $messagePlayload)
    {
        $this->eventClassName = $eventClassName;
        $this->messagePlayload = $messagePlayload;
    }

    /**
     * @return string
     */
    public function getEventClassName()
    {
        return $this->eventClassName;
    }

    /**
     * @return mixed
     */
    public function getMessagePlayload()
    {
        return $this->messagePlayload;
    }

    public function hasPlayload()
    {
        return $this->messagePlayload !== null;
    }


}