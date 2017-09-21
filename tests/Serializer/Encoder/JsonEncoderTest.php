<?php

namespace Solis\Foundation;

use Solis\Foundation\Serializer\Encoder\AbstractEncoder;
use Solis\Foundation\Serializer\Encoder\JsonEncoder;
use Solis\Foundation\Tests\Serializer\Dummy\DummyData;
use PHPUnit\Framework\TestCase;

class JsonEncoderTest extends TestCase
{

    /**
     * @var AbstractEncoder
     */
    private $encoder;

    private $data;

    public function setUp()
    {
        $this->encoder = JsonEncoder::make();
        $this->data    = (new DummyData())->getData();
    }

    public function testCanEncodeArrayDataAsJson()
    {
        $isJson = $this->isValidJson($this->encoder->encode($this->data));
        $this->assertEquals(true, $isJson, 'Cannot encode array data into json format');
    }

    private function isValidJson($data)
    {
        return boolval(json_encode(json_decode($this->encoder->encode($data), true)));
    }
}
