AsyncEventDispatcher Component
==============================

[![Build Status](https://travis-ci.org/solilokiam/asynceventdispatcher.svg?branch=master)](https://travis-ci.org/solilokiam/asynceventdispatcher)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/ac193ca5-c894-47ac-b1c7-12c2d9e31124/mini.png)](https://insight.sensiolabs.com/projects/ac193ca5-c894-47ac-b1c7-12c2d9e31124)
[![Dependency Status](https://www.versioneye.com/user/projects/544bc44497ae388a46000120/badge.svg?style=flat)](https://www.versioneye.com/user/projects/544bc44497ae388a46000120)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/solilokiam/asynceventdispatcher/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/solilokiam/asynceventdispatcher/?branch=master)


This component is an async event dispatcher based on the Symfony's event dispatcher component but in a fire and forget way.
Right now it needs Redis to work but if you use another queue system it's really easy to extend and use.

Warning
-------
This code is not ready for production. This is still a Work in progress, things may change a lot over time.

Installation
------------
### Using composer
Add following lines to your `composer.json` file:
```json
"require": {
      ...
      "solilokiam/async-event-dispatcher": "dev-master"
    },
```

How do you dispatch events?
---------------------------

If you've already used symfony event dispatcher it's really simple to use. First you need to create your own event.
This event must extend `AsyncEvent` . Once you've got your event created you need to dispatch it using the
`AsyncEventDispatcher`. You need to inject an object that implements `EventDriverInterface` when you instantiate the `AsyncEventDispatcher` class.
This component provides you with a RabbitMq implementation of the interface. Feel free to create your own if you need it.

In the following example you can see how to do it:

```php
namespace Foo\Events;

use Solilokiam\AsyncEventDispatcher\AsyncEvent;

class FooAsyncEvent extends AsyncEvent
{
    protected $foo;

    public function setFoo($value)
    {
        $this->foo = $value;

        return $this;
    }

    public function getFoo()
    {
        return $this->foo;
    }
}
```

```php
$redirEventDriver = new RedisDriver($redisConfig);

$asyncEventDispatcher = new AsyncEventDispatcher($redisEventDriver);

$fooEvent = new FooAsyncEvent();
$fooEvent->setFoo('whatever');

$dispatcher->dispatch('foo.event', $fooEvent);
```

How do you define event listeners?
----------------------------------
TODO

How do you consume dispatcher events?
-------------------------------------
TODO

License
-------
AsyncEventDispatcher is licensed under the MIT License. See the LICENSE file for full details.
