<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 14/09/14
 * Time: 18:50
 */
namespace Solilokiam\AsyncEventDispatcher;

/**
 * The AsyncEventDispatcherListenerManager has the mission to register which events have which listeners. It's one
 * of the central pieces of the consumer part of the async event dispatcher.
 *
 * @package Solilokiam\AsyncEventDispatcher
 *
 * @author Miquel Company Rodriguez <miquel@solilokiam.com>
 */
interface AsyncEventDispatcherListenerManagerInterface
{
    /**
     * Adds an event listener that listen to specified events
     *
     * @param string $eventName The event to listen on
     * @param callable $listener The listener
     * @return void
     */
    public function addListener($eventName, Callable $listener);

    /**
     * Gets the event listeners of specific events or all events
     *
     * @param null $eventName The name of the event
     * @return array The event listeners for specified event, or all events by event name
     */
    public function getListeners($eventName = null);

    /**
     * Checks wether an event has any registered events or if there's any registered event at all
     *
     * @param null $eventName The name of the event
     * @return boolean true if it has any registered event, false otherwise
     */
    public function hasListeners($eventName = null);

    /**
     * Removes an event listener from the specified event
     *
     * @param string $eventName The event to remove the listener from
     * @param callable $listener The listener to remove
     * @return void
     */
    public function removeListener($eventName, Callable $listener);
}
