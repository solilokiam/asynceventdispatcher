<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 13/09/14
 * Time: 22:15
 */

namespace Solilokiam\AsyncEventDispatcher\tests;

use Solilokiam\AsyncEventDispatcher\AsyncEventDispatcherListenerManager;

class AsyncEventDispatcherListenerManagerTest extends \PHPUnit_Framework_TestCase
{
    const event1 = 'event1';
    const event2 = 'event2';
    protected $listener;
    protected $eventListener;

    public function testEmptyGetListener()
    {
        $listeners = $this->eventListener->getListeners(self::event1);
        $this->assertTrue(is_array($listeners));
    }

    public function testAddListener()
    {
        $this->eventListener->addListener(self::event1, array($this->listener, 'onEvent1'));
        $this->eventListener->addListener(self::event2, array($this->listener, 'onEvent2'));
        $this->assertTrue($this->eventListener->hasListeners(self::event1));
        $this->assertTrue($this->eventListener->hasListeners(self::event2));
        $this->assertCount(1, $this->eventListener->getListeners(self::event1));
        $this->assertCount(1, $this->eventListener->getListeners(self::event2));
        $this->assertCount(2, $this->eventListener->getListeners());
    }

    public function testRemoveListener()
    {
        $this->eventListener->addListener(self::event1, array($this->listener, 'onEvent1'));
        $this->eventListener->removeListener('unexistantEvent', array($this->listener, 'onEvent1'));
        $this->assertCount(1, $this->eventListener->getListeners());
        $this->eventListener->removeListener(self::event1, array($this->listener, 'onEvent1'));
        $this->assertCount(0, $this->eventListener->getListeners(self::event1));
    }

    protected function setUp()
    {
        $this->eventListener = new AsyncEventDispatcherListenerManager();
        $this->listener = new AsyncEventListenerTest();
    }

    protected function tearDown()
    {
        unset($this->eventListener);
        unset($this->listener);
    }
}
