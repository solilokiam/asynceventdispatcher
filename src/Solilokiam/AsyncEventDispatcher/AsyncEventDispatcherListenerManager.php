<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 13/09/14
 * Time: 22:04
 */

namespace Solilokiam\AsyncEventDispatcher;

/**
 * Class AsyncEventDispatcherListenerManager
 * @package Solilokiam\AsyncEventDispatcher
 *
 * @author Miquel Company Rodriguez <miquel@solilokiam.com>
 */
class AsyncEventDispatcherListenerManager implements AsyncEventDispatcherListenerManagerInterface
{
    /**
     * @var array
     */
    private $listeners = array();

    /**
     * @see AsyncEventDispatcherListenerManagerInterface::hasListeners
     */
    public function hasListeners($eventName = null)
    {
        return (bool)count($this->getListeners($eventName));
    }

    /**
     * @see AsyncEventDispatcherListenerManagerInterface::getListeners
     */
    public function getListeners($eventName = null)
    {
        if (null !== $eventName) {
            if (array_key_exists($eventName, $this->listeners)) {
                return $this->listeners[$eventName];
            } else {
                return array();
            }
        }

        return array_filter($this->listeners);
    }

    /**
     * @see AsyncEventDispatcherListenerManagerInterface::addListener
     */
    public function addListener($eventName, callable $listener)
    {
        $this->listeners[$eventName][] = $listener;
    }

    /**
     * @see AsyncEventDispatcherListenerManagerInterface::removeListener
     */
    public function removeListener($eventName, callable $listener)
    {
        if (!isset($this->listeners[$eventName])) {
            return;
        }

        foreach ($this->listeners[$eventName] as $key => $listeners) {
            if ($this->listeners[$eventName][$key] === $listener) {
                unset($this->listeners[$eventName][$key]);
            }
        }
    }
}
