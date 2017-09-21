<?php

namespace Solis\Foundation\Tests\Arrays\Dummy;


class DummyDataCollection
{

    public function getData()
    {
        return [
            [
                'date' => Date('Y-m-d'),
            ],
            [
                'date' => Date('Y-m-d'),
            ],
        ];
    }
}