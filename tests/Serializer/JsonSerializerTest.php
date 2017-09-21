<?php

namespace Solis\Foundation\Tests\Serializer;

use PHPUnit\Framework\TestCase;
use Solis\Foundation\Serializer\AbstractSerializer;
use Solis\Foundation\Serializer\JsonSerializer;
use Solis\Foundation\Tests\Serializer\Dummy\DummyData;

class JsonSerializerTest extends TestCase
{
    /**
     * @var AbstractSerializer
     */
    private $serializer;

    private $data;

    public function setUp()
    {
        $this->serializer = JsonSerializer::make();
        $this->data       = (new DummyData())->getData();
    }

    public function testInstanceOfAbstractSerializer()
    {
        $this->assertInstanceOf(
            'Solis\\Foundation\\Serializer\\AbstractSerializer',
            $this->serializer,
            'JsonSerializer is not instance of AbstractSerializer'
        );
    }

    public function testCanEncodeArrayAsJson()
    {
        $json = $this->serializer->encode($this->data, 'json');
        $isJson = boolval(json_encode(json_decode($json, true)));
        $this->assertEquals(true, $isJson, 'Cannot encode array data into json format');
    }
}
