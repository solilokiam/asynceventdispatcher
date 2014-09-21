<?php
/**
 * Created by PhpStorm.
 * User: miquel
 * Date: 21/09/14
 * Time: 18:36
 */

namespace Solilokiam\AsyncEventDispatcher\EventDriver;


use JMS\Serializer\Serializer;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Solilokiam\AsyncEventDispatcher\AsyncEvent;

class RabbitDriver implements EventDriverInterface
{
    protected $serializer;

    protected $config;

    protected $callback;

    protected $consumedMessages = 0;

    function __construct(RabbitDriverConfig $config, Serializer $serializer, $callback)
    {
        $this->config = $config;
        $this->serializer = $serializer;
        $this->callback = $callback;
    }


    /**
     * @param $eventName
     * @param AsyncEvent $event
     */
    public function publish($eventName, AsyncEvent $event)
    {
        $serializedEvent = $this->serializer->serialize($eventName,$this->config->getSerializerFormat());

        $connection = new AMQPConnection($this->config->getHost(),$this->config->getPort(),$this->config->getUsername(),$this->config->getPassword());
        $channel = $connection->channel();
        $channel->exchange_declare($eventName,'fanout',false, false, false);
        $msg = new AMQPMessage($serializedEvent);
        $channel->basic_publish($msg,$this->config->getExchangeName());

        // TODO: Implement publish() method.
    }

    /**
     * @return AsyncEvent
     */
    public function consume($eventName,$messageNumber)
    {
        $consumerTag = md5(time());
        $connection = new AMQPConnection($this->config->getHost(),$this->config->getPort(),$this->config->getUsername(),$this->config->getPassword());
        $channel = $connection->channel();
        $channel->exchange_declare($eventName,'fanout',false, false, false);
        list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);
        $channel->queue_bind($queue_name, 'logs');
        $channel->basic_consume($queue_name, $consumerTag, false, true, false, false, array($this,'consumeMessage'));
        while(count($channel->callbacks)) {
            if($this->consumedMessages >= $messageNumber)
            {
                $channel->basic_cancel($consumerTag);
            }
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }

    public function consumeMessage(AMQPMessage $msg)
    {
        $this->consumedMessages++;

        $event = $this->serializer->deserialize($msg->body,'Solilokiam\AsyncEventDispatcher\AsyncEvent',$this->config->getSerializerFormat());

        call_user_func($this->callable,$event);
    }
} 