<?php

namespace Solis\Foundation;

use PHPUnit\Framework\TestCase;
use Solis\Foundation\Serializer\Encoder\EncoderContainer;
use Solis\Foundation\Tests\Serializer\Dummy\DummyEncoder;

class EncoderContainerTest extends TestCase
{

    /**
     * @var EncoderContainer
     */
    private $encoder;

    public function setUp()
    {
        $this->encoder = new EncoderContainer([DummyEncoder::make()]);
    }

    public function testCanGetEncoderByType()
    {
        $encoder = $this->encoder->getEncoder('dummy');
        $this->assertNotInternalType('null', $encoder, 'Can\'t get encoder by type in encoder container');
    }
}
