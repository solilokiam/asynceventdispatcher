<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 13/09/14
 * Time: 21:49
 */

namespace Solilokiam\AsyncEventDispatcher\tests;

use Mockery as m;
use Solilokiam\AsyncEventDispatcher\AsyncEvent;
use Solilokiam\AsyncEventDispatcher\AsyncEventDispatcher;

class AsyncEventDispatcherTest extends \PHPUnit_Framework_TestCase
{
    public function testDispatcher()
    {
        $event = new AsyncEvent();
        $eventName = 'test.event';

        $eventDriverMock = m::mock('Solilokiam\AsyncEventDispatcher\EventDriver\EventDriverInterface');
        $eventDriverMock->shouldReceive('publish')->times(1)->with($eventName, $event);

        $dispatcher = new AsyncEventDispatcher($eventDriverMock);
        $dispatcher->dispatch($eventName, $event);
    }

    public function testDispatcherEmptyEvent()
    {
        $eventName = 'test.event';

        $eventDriverMock = m::mock('Solilokiam\AsyncEventDispatcher\EventDriver\EventDriverInterface');
        $eventDriverMock->shouldReceive('publish')->times(1);

        $dispatcher = new AsyncEventDispatcher($eventDriverMock);
        $dispatcher->dispatch($eventName);
    }

    protected function tearDown()
    {
        m::close();
    }
}
