<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 13/09/14
 * Time: 21:43
 */

namespace Solilokiam\AsyncEventDispatcher\tests;

use Solilokiam\AsyncEventDispatcher\AsyncEvent;

class AsyncEventTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultPropagationStopped()
    {
        $event = new AsyncEvent();
        //By default propagation must be stopped
        $this->assertFalse($event->isPropagationStopped());
    }

    public function testStopPropagation()
    {
        $event = new AsyncEvent();
        $event->stopPropagation();
        $this->assertTrue($event->isPropagationStopped());
    }
}
