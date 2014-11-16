<?php

namespace Solilokiam\AsyncEventDispatcher\EventSerializer;

/**
 * Class AsyncEventMessage
 * @package Solilokiam\AsyncEventDispatcher\EventSerializer
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
     * @var string
     */
    protected $messagePlayloadFormat;

    /**
     * @param $eventClassName
     * @param $messagePlayload
     * @param $messagePlayloadFormat
     */
    public function __construct($eventClassName, $messagePlayload, $messagePlayloadFormat)
    {
        $this->eventClassName = $eventClassName;
        $this->messagePlayload = $messagePlayload;
        $this->messagePlayloadFormat = $messagePlayloadFormat;
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

    /**
     * @return string
     */
    public function getMessagePlayloadFormat()
    {
        return $this->messagePlayloadFormat;
    }
}
