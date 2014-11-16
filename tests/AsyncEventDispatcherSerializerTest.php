<?php


namespace Solilokiam\AsyncEventDispatcher\tests;


use Mockery as m;
use Solilokiam\AsyncEventDispatcher\AsyncEvent;
use Solilokiam\AsyncEventDispatcher\EventSerializer\AsyncEventDispatcherSerializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class AsyncEventDispatcherSerializerTest extends \PHPUnit_Framework_TestCase
{
    private $seralizedDummyEvent = '{"eventClassName":"Solilokiam\\\AsyncEventDispatcher\\\AsyncEvent","messagePlayload":"{\"propagationStopped\":false}","messagePlayloadFormat":"json"}';

    public function testSerialize()
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $asyncEventSerializer = new AsyncEventDispatcherSerializer($serializer);

        $event = new AsyncEvent();

        $return = $asyncEventSerializer->serialize($event, 'json');

        $this->assertEquals($this->seralizedDummyEvent, $return);
    }

    public function testDeserialie()
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $asyncEventSerializer = new AsyncEventDispatcherSerializer($serializer);

        $event = new AsyncEvent();

        $return = $asyncEventSerializer->deserialize($this->seralizedDummyEvent, 'json');

        $this->assertEquals($event, $return);
    }
} 