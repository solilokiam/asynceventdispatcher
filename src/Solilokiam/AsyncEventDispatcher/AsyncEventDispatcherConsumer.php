<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 14/09/14
 * Time: 18:49
 */

namespace Solilokiam\AsyncEventDispatcher;


use Solilokiam\AsyncEventDispatcher\EventDriver\EventDriverInterface;

/**
 * Class AsyncEventDispatcherObserver
 * @package Solilokiam\AsyncEventDispatcher
 *
 * @author Miquel Company Rodriguez <miquel@solilokiam.com>
 */
class AsyncEventDispatcherConsumer
{
    /**
     * @var EventDriver\EventDriverInterface
     */
    protected $eventDriver;
    /**
     * @var AsyncEventDispatcherListenerManagerInterface
     */
    protected $eventListenerManager;

    protected $eventName;

    /**
     * @param EventDriverInterface $eventDriver
     * @param AsyncEventDispatcherListenerManagerInterface $eventListenerManager
     */
    function __construct(
        EventDriverInterface $eventDriver,
        AsyncEventDispatcherListenerManagerInterface $eventListenerManager,
        $eventName
    )
    {
        $this->eventDriver = $eventDriver;
        $this->eventListenerManager = $eventListenerManager;
        $this->eventName = $eventName;
    }

    /**
     * @param $eventName
     * @param $messagesNumber
     */
    public function activateConsumer($messagesNumber)
    {
        $this->eventDriver->consume(array($this,'consume'),$messagesNumber);
    }

    public function consume(AsyncEvent $event)
    {
        $listeners = $this->eventListenerManager->getListeners($this->eventName);

        foreach ($listeners as $listener) {
            call_user_func($listener, $event, $this->eventName, $this);
            if ($event->isPropagationStopped()) {
                break;
            }
        }
    }


}
