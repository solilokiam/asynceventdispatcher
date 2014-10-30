<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 25/10/14
 * Time: 21:13
 */

namespace Solilokiam\AsyncEventDispatcher\EventDriver;


use JMS\Serializer\SerializerInterface;
use Predis\Client;
use Solilokiam\AsyncEventDispatcher\AsyncEvent;

class RedisDriver implements EventDriverInterface
{

    protected $config;
    protected $serializer;

    function __construct(RedisDriverConfig $config, SerializerInterface $serializer)
    {
        $this->config = $config;
        $this->serializer = $serializer;
    }

    /**
     * @param string $eventName
     * @param AsyncEvent $event
     * @return void
     */
    public function publish($eventName, AsyncEvent $event)
    {
        $client = new Client($this->config->getConnectionConfigArray());

        $serializedEvent = $this->serializer->serialize($event, $this->config->getSerializerFormat());

        $client->lpush($this->getKey($eventName), $serializedEvent);
    }

    /**
     * @return AsyncEvent
     */
    public function consume($eventName, $eventCallback, $messageNumber)
    {
        $client = new Client($this->config->getConnectionConfigArray());
        $processedMessages = 0;

        while (true) {
            $message = $client->rpop($this->getKey($eventName));

            if ($message !== null) {
                $event = $this->serializer->deserialize($message, $this->config->getSerializerFormat());

                call_user_func($eventCallback, $event);

                $processedMessages++;
            }

            if ($processedMessages >= $message) {
                break;
            }

        }
    }

    protected function getKeyPrefix($eventName)
    {
        return $this->config->getKeyPrefix() . '_' . $eventName;
    }

} 