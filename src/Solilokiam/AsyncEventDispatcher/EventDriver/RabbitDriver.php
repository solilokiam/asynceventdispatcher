<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 21/09/14
 * Time: 18:36
 */

namespace Solilokiam\AsyncEventDispatcher\EventDriver;

use JMS\Serializer\SerializerInterface;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Solilokiam\AsyncEventDispatcher\AsyncEvent;

class RabbitDriver implements EventDriverInterface
{
    protected $serializer;

    protected $config;

    protected $consumedMessages = 0;

    public function __construct(RabbitDriverConfig $config, SerializerInterface $serializer)
    {
        $this->config = $config;
        $this->serializer = $serializer;
    }

    /**
     * @param string $eventName
     * @param AsyncEvent $event
     */
    public function publish($eventName, AsyncEvent $event)
    {
        $serializedEvent = $this->serializer->serialize($eventName, $this->config->getSerializerFormat());

        $channel = $this->getPublishChannel($eventName);

        $msg = new AMQPMessage($serializedEvent);

        $channel->basic_publish($msg, $eventName);
    }

    /**
     * @param  string $eventName
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    protected function getPublishChannel($eventName)
    {
        $connection = new AMQPConnection($this->config->getHost(), $this->config->getPort(),
            $this->config->getUsername(), $this->config->getPassword());
        $channel = $connection->channel();
        $channel->exchange_declare($eventName, 'fanout', false, false, false);

        return $channel;
    }

    /**
     * @return AsyncEvent
     */
    public function consume($eventName, $eventCallback, $messageNumber)
    {
        $consumerTag = md5(time());
        $connection = new AMQPConnection($this->config->getHost(), $this->config->getPort(),
            $this->config->getUsername(), $this->config->getPassword());
        $channel = $connection->channel();
        $channel->exchange_declare($eventName, 'fanout', false, false, false);
        list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);
        $channel->queue_bind($queue_name, 'logs');
        $channel->basic_consume($queue_name, $consumerTag, false, true, false, false, $eventCallback);

        while (count($channel->callbacks)) {
            if ($this->consumedMessages >= $messageNumber) {
                $channel->basic_cancel($consumerTag);
            }
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }
}
