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
     * @param string $eventName
     * @param AsyncEvent $event
     * @return void
     */
    public function publish($eventName, AsyncEvent $event);

    /**
     * @return AsyncEvent
     */
    public function consume($eventName, $eventCallback, $messageNumber);
}
