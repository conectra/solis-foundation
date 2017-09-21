<?php

namespace Solis\Foundation\Serializer\Encoder;

abstract class AbstractEncoder
{

    protected $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    abstract public function encode($data);
}
