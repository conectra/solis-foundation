<?php

namespace Solis\Foundation\Tests\Serializer\Dummy;

class DummyData
{

    public function getData()
    {
        return [
            'date' => Date('Y-m-d'),
            'hour' => Date('H:i:s'),
        ];
    }
}
