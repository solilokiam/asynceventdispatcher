<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 14/09/14
 * Time: 19:24
 */

namespace Solilokiam\AsyncEventDispatcher\Tests;

use Mockery as m;
use Solilokiam\AsyncEventDispatcher\AsyncEventDispatcherConsumer;

class AsyncEventDispatcherConsumerTest extends \PHPUnit_Framework_TestCase
{
    public function testActivateConsume()
    {
        $eventDriverMock = m::mock('Solilokiam\AsyncEventDispatcher\EventDriver\EventDriverInterface');
        $eventDriverMock->shouldReceive('consume')->times(1)->with('foo.event', m::type('callable'), 10);

        $eventListenerManagerMock = m::mock('Solilokiam\AsyncEventDispatcher\AsyncEventDispatcherListenerManager');

        $asyncEventDispatcherConsumer = new AsyncEventDispatcherConsumer($eventDriverMock, $eventListenerManagerMock,
            'foo.event');
        $asyncEventDispatcherConsumer->activateConsumer(10);
    }

    public function testEmptyConsume()
    {
        $eventDriverMock = m::mock('Solilokiam\AsyncEventDispatcher\EventDriver\EventDriverInterface');
        $eventListenerManagerMock = m::mock('Solilokiam\AsyncEventDispatcher\AsyncEventDispatcherListenerManager');
        $eventListenerManagerMock->shouldReceive('getListeners')->times(1)->with('foo.event')->andReturn(array());
        $asyncEventMock = m::mock('Solilokiam\AsyncEventDispatcher\AsyncEvent');

        $asyncEventDispatcherConsumer = new AsyncEventDispatcherConsumer($eventDriverMock, $eventListenerManagerMock, 'foo.event');

        $asyncEventDispatcherConsumer->consume($asyncEventMock);
    }

    public function testConsumeWithListeners()
    {
        $eventDriverMock = m::mock('Solilokiam\AsyncEventDispatcher\EventDriver\EventDriverInterface');
        $eventListenerManagerMock = m::mock('Solilokiam\AsyncEventDispatcher\AsyncEventDispatcherListenerManager');

        $listener1 = function () use (&$invoked) {
            $invoked[] = '1';
        };

        $listener2 = function () use (&$invoked) {
            $invoked[] = '2';
        };

        $eventListenerManagerMock->shouldReceive('getListeners')->times(1)->with('foo.event')->andReturn(array(
            $listener1,
            $listener2
        ));
        $asyncEventMock = m::mock('Solilokiam\AsyncEventDispatcher\AsyncEvent');
        $asyncEventMock->shouldReceive('isPropagationStopped')->times(2)->andReturn(false);

        $asyncEventDispatcherConsumer = new AsyncEventDispatcherConsumer($eventDriverMock, $eventListenerManagerMock, 'foo.event');

        $asyncEventDispatcherConsumer->consume($asyncEventMock);

        $this->assertEquals(array('1', '2'), $invoked);
    }

    public function testConsumeWithListenersPropagationStopped()
    {
        $eventDriverMock = m::mock('Solilokiam\AsyncEventDispatcher\EventDriver\EventDriverInterface');
        $eventListenerManagerMock = m::mock('Solilokiam\AsyncEventDispatcher\AsyncEventDispatcherListenerManager');

        $listener1 = function () use (&$invoked) {
            $invoked[] = '1';
        };

        $listener2 = function () use (&$invoked) {
            $invoked[] = '2';
        };

        $eventListenerManagerMock->shouldReceive('getListeners')->times(1)->with('foo.event')->andReturn(array(
            $listener1,
            $listener2
        ));
        $asyncEventMock = m::mock('Solilokiam\AsyncEventDispatcher\AsyncEvent');
        $asyncEventMock->shouldReceive('isPropagationStopped')->times(1)->andReturn(true);

        $asyncEventDispatcherConsumer = new AsyncEventDispatcherConsumer($eventDriverMock, $eventListenerManagerMock,
            'foo.event');

        $asyncEventDispatcherConsumer->consume($asyncEventMock);

        $this->assertEquals(array('1'), $invoked);
    }

    protected function tearDown()
    {
        m::close();
    }

}
 