<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 13/09/14
 * Time: 22:19
 */

namespace Solilokiam\AsyncEventDispatcher\tests;

use Solilokiam\AsyncEventDispatcher\AsyncEvent;

class AsyncEventListenerTest
{
    public $event1Invoked = false;
    public $event2Invoked = false;

    /* Listener methods */

    public function onEvent1(AsyncEvent $e)
    {
        $this->event1Invoked = true;
    }

    public function onEvent2(AsyncEvent $e)
    {
        $this->event2Invoked = true;

        $e->stopPropagation();
    }
}
