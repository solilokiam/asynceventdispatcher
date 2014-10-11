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
    protected function tearDown()
    {
        m::close();
    }

    public function testActivateConsume()
    {
        $eventDriverMock = m::mock('Solilokiam\AsyncEventDispatcher\EventDriver\EventDriverInterface');
        $eventDriverMock->shouldReceive('consume')->times(1)->with(m::type('callable'),10);

        $eventListenerManagerMock = m::mock('Solilokiam\AsyncEventdispatcher\AsyncEventDispatcherListenerManager');

        $asyncEventDispatcherConsumer = new AsyncEventDispatcherConsumer($eventDriverMock,$eventListenerManagerMock,'foo.event');
        $asyncEventDispatcherConsumer->activateConsumer(10);
    }

}
 