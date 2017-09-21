<?php

namespace Solis\Foundation\Serializer;

use Solis\Foundation\Serializer\Encoder\JsonEncoder;

class JsonSerializer extends AbstractSerializer
{

    public static function make()
    {
        $encoders = [
            JsonEncoder::make(),
        ];

        return new static($encoders);
    }
}
