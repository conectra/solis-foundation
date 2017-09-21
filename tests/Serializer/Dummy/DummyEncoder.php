<?php


namespace Solis\Foundation\Tests\Serializer\Dummy;

use Solis\Foundation\Serializer\Encoder\AbstractEncoder;

class DummyEncoder extends AbstractEncoder
{

    public static function make()
    {
        return new static('dummy');
    }

    public function encode($data)
    {
        return 'dummy';
    }
}
