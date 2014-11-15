<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 13/09/14
 * Time: 21:49
 */
namespace Solilokiam\AsyncEventDispatcher;

/**
 * Interface AsyncEventDispatcherInterface
 * @package Solilokiam\AsyncEventDispatcher
 *
 * @author Miquel Company Rodriguez <miquel@solilokiam.com>
 */
interface AsyncEventDispatcherInterface
{
    /**
     * Send an event message to the async event dispatcher observer.
     *
     * @param string $eventName The name of the event to dispatch. The name of
     *                              the event is the name of the method that is
     *                              invoked on listeners.
     * @param AsyncEvent $event The event to pass to the event handlers/listeners.
     *                              If not supplied, an empty Event instance is created.
     *
     * @return Event|null
     *
     * @api
     */
    public function dispatch($eventName, AsyncEvent $event = null);
}
