<?php
namespace Solilokiam\AsyncEventDispatcher\EventSerializer;

use Solilokiam\AsyncEventDispatcher\AsyncEvent;

/**
 * Class AsyncEventDispatcherSerializer
 * @package Solilokiam\AsyncEventDispatcher\EventSerializer
 */
interface AsyncEventDispatcherSerializerInterface
{
    /**
     * @param  AsyncEvent $event
     * @param $format
     * @return mixed
     */
    public function serialize(AsyncEvent $event, $format);

    /**
     * @param $serializedMessage
     * @param $format
     * @return null|AsyncEvent
     */
    public function deserialize($serializedMessage, $format);
}
