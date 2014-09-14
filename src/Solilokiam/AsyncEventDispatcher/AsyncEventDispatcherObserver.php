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
class AsyncEventDispatcherObserver
{
    /**
     * @var EventDriver\EventDriverInterface
     */
    protected $eventDriver;
    /**
     * @var AsyncEventDispatcherListenerManagerInterface
     */
    protected $eventListenerManager;

    private $consumed = 0;

    /**
     * @param EventDriverInterface $eventDriver
     * @param AsyncEventDispatcherListenerManagerInterface $eventListenerManager
     */
    function __construct(
        EventDriverInterface $eventDriver,
        AsyncEventDispatcherListenerManagerInterface $eventListenerManager
    )
    {
        $this->eventDriver = $eventDriver;
        $this->eventListenerManager = $eventListenerManager;
    }

    /**
     * @param $eventName
     * @param $messagesNumber
     */
    public function consume($eventName, $messagesNumber)
    {
        while (true) {
            $listeners = $this->eventListenerManager->getListeners($eventName);
            $event = $this->eventDriver->consume($eventName);

            foreach ($listeners as $listener) {
                call_user_func($listener, $event, $eventName, $this);
                if ($event->isPropagationStopped()) {
                    break;
                }
            }

            $this->consumed++;

            if ($this->consumed >= $messagesNumber) {
                break;
            }
        }
    }


} 