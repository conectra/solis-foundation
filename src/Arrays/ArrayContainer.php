<?php

namespace Solis\Foundation\Arrays;

use Solis\Foundation\Serializer\AbstractSerializer;
use Solis\Foundation\Serializer\JsonSerializer;

class ArrayContainer
{

    private $array = [];

    private $serializer;

    public function __construct(AbstractSerializer $serializer, array $array = [])
    {
        $this->array      = $array;
        $this->serializer = $serializer;
    }

    public static function make($array = [])
    {
        return new static(JsonSerializer::make(), $array);
    }

    public function get($index)
    {
        return $this->array[$index] ?? null;
    }

    public function set($index, $value)
    {
        $this->array[$index] = $value;
    }

    public function keys()
    {
        return array_keys($this->array);
    }

    public function values()
    {
        return array_values($this->array);
    }

    public function remove($index)
    {
        unset($this->array[$index]);
    }

    public function toArray()
    {
        return $this->array;
    }

    public function toJson()
    {
        return $this->serializer->encode($this->toArray(), 'json');
    }
}
