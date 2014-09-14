<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 08/09/14
 * Time: 21:55
 */

namespace Solilokiam\AsyncEventDispatcher\EventDriver;

use Solilokiam\AsyncEventDispatcher\AsyncEvent;

interface EventDriverInterface
{

    /**
     * @param $eventName
     * @param AsyncEvent $event
     */
    public function publish($eventName, AsyncEvent $event);

    /**
     * @return AsyncEvent
     */
    public function consume($eventName);
} 