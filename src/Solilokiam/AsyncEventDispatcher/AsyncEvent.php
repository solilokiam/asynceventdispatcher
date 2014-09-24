<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 07/09/14
 * Time: 19:25
 */

namespace Solilokiam\AsyncEventDispatcher;


/**
 * The async event is the parent class for all classes containing event data.
 *
 * @package Solilokiam\AsyncEventDispatcher
 *
 * @author Miquel Company Rodriguez <miquel@solilokiam.com>
 */
class AsyncEvent
{
    /**
     * @var bool    Whether no further event listeners should be triggered
     */
    private $propagationStopped = false;

    /**
     * Stops the propagation of the event to further event listeners. If multiple event listeners are
     * listening to the same event, no further event listener call will be made once stopPropagation is triggered.
     */
    public function stopPropagation()
    {
        $this->propagationStopped = true;
    }

    /**
     * Returns whether stop event propagation is triggered or not
     *
     * @return bool
     */
    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }

}
