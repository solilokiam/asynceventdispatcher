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
     * @return string
     */
    public function serialize(AsyncEvent $event, $format);

    /**
     * @param $serializedMessage
     * @param $format
     * @return null|object
     */
    public function deserialize($serializedMessage, $format);
}
