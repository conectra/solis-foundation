<?php

namespace Solis\Foundation\Tests\Serializer\Dummy;

use Solis\Foundation\Serializer\AbstractSerializer;

class DummySerializer extends AbstractSerializer
{

    public static function make()
    {
        $encoders = [
            DummyEncoder::make(),
        ];

        return new static($encoders);
    }
}
