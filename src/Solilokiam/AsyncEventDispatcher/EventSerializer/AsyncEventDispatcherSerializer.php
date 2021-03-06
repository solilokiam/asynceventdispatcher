<?php

namespace Solilokiam\AsyncEventDispatcher\EventSerializer;


use Solilokiam\AsyncEventDispatcher\AsyncEvent;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AsyncEventDispatcherSerializer
 * @package Solilokiam\AsyncEventDispatcher\EventSerializer
 */
class AsyncEventDispatcherSerializer implements AsyncEventDispatcherSerializerInterface
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param  AsyncEvent $event
     * @param $format
     * @return string
     */
    public function serialize(AsyncEvent $event, $format)
    {
        $serializedEvent = $this->serializer->serialize($event, $format);

        $message = new AsyncEventMessage(get_class($event), $serializedEvent, $format);

        $serializedMessage = $this->serializer->serialize($message, $format);

        return $serializedMessage;
    }

    /**
     * @param string $serializedMessage
     * @param string $format
     * @return object
     */
    public function deserialize($serializedMessage, $format)
    {
        $message = $this->serializer->deserialize($serializedMessage,
            'Solilokiam\AsyncEventDispatcher\EventSerializer\AsyncEventMessage', $format);

        return $this->serializer->deserialize($message->getMessagePlayload(), $message->getEventClassName(),
            $message->getMessagePlayloadFormat());
    }
}
