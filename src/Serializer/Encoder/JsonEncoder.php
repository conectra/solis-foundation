<?php

namespace Solis\Foundation\Serializer\Encoder;

class JsonEncoder extends AbstractEncoder
{

    public static function make()
    {
        return new static('json');
    }

    public function encode($data)
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
