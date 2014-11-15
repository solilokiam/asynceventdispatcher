<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 25/10/14
 * Time: 21:13
 */

namespace Solilokiam\AsyncEventDispatcher\EventDriver;

use Predis\Client;
use Solilokiam\AsyncEventDispatcher\AsyncEvent;
use Solilokiam\AsyncEventDispatcher\EventSerializer\AsyncEventDispatcherSerializerInterface;

class RedisDriver implements EventDriverInterface
{
    protected $config;
    protected $serializer;

    public function __construct(RedisDriverConfig $config, AsyncEventDispatcherSerializerInterface $serializer)
    {
        $this->config = $config;
        $this->serializer = $serializer;
    }

    /**
     * @param  string $eventName
     * @param  AsyncEvent $event
     * @return void
     */
    public function publish($eventName, AsyncEvent $event)
    {
        $client = new Client($this->config->getConnectionConfigArray());

        $serializedEvent = $this->serializer->serialize($event, $this->config->getSerializerFormat());

        $client->lpush($this->getKey($eventName), $serializedEvent);
    }

    protected function getKey($eventName)
    {
        return $this->config->getKeyPrefix() . '_' . $eventName;
    }

    /**
     * @return AsyncEvent
     */
    public function consume($eventName, $eventCallback, $messageNumber)
    {
        $client = new Client($this->config->getConnectionConfigArray());
        $processedMessages = 0;

        while (true) {
            $serializedMessage = $client->rpop($this->getKey($eventName));

            $event = $this->serializer->deserialize($serializedMessage, $this->config->getSerializerFormat());

            if ($event !== null) {
                call_user_func($eventCallback, $event);

                $processedMessages++;
            }

            if ($processedMessages >= $messageNumber) {
                break;
            }
        }
    }
}
