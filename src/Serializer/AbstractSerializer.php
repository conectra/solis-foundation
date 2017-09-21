<?php

namespace Solis\Foundation\Serializer;

use Solis\Foundation\Serializer\Encoder\EncoderContainer;

abstract class AbstractSerializer
{

    private $encoder;

    public function __construct(array $encoders)
    {
        $this->encoder = new EncoderContainer($encoders);
    }

    public function encode($data, $type)
    {
        $encoder = $this->getEncoder($type);

        return $encoder->encode($data);
    }

    public function getEncoder($type)
    {
        return $this->encoder->getEncoder($type) ?? null;
    }
}
