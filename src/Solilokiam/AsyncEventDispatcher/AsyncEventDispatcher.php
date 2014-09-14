<?php
namespace Solilokiam\AsyncEventDispatcher;

use Solilokiam\AsyncEventDispatcher\EventDriver\EventDriverInterface;

/**
 * Class AsyncEventDispatcher
 * @package Solilokiam\AsyncEventDispatcher
 *
 * @author Miquel Company Rodriguez <miquel@solilokiam.com>
 */
class AsyncEventDispatcher implements AsyncEventDispatcherInterface
{
    protected $eventDriver;

    function __construct(EventDriverInterface $eventDriver)
    {
        $this->eventDriver = $eventDriver;
    }


    /**
     * @see AsyncEventDispatcher::dispatch
     */
    public function dispatch($eventName, AsyncEvent $event = null)
    {
        if ($event == null) {
            $event = new AsyncEvent();
        }

        $this->eventDriver->publish($eventName, $event);
    }

} 