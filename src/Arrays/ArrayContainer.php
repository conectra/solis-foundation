<?php

namespace Solis\Foundation\Arrays;

class ArrayContainer
{
    private $array = [];

    public function __construct(array $array = [])
    {
        $this->array = $array;
    }

    public function get($index)
    {
        return $this->array[$index] ?? null;
    }

    public function set($index, $value)
    {
        $this->array[$index] = $value;
    }

    public function first()
    {
        return $this->array[0] ?? null;
    }

    public function last()
    {
        return $this->array[$this->count() - 1] ?? null;
    }

    public function count()
    {
        return count($this->array);
    }

    public function keys()
    {
        return array_keys($this->array);
    }

    public function values()
    {
        return array_values($this->array);
    }


    public function __unset($index)
    {
        unset($this->array[$index]);
    }

    public function toArray()
    {
        return $this->array;
    }

    public function toJson()
    {
        return json_encode($this->serialize(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function serialize()
    {
        $entries = array_map(function ($entry) {
            return $this->serializeEntry($entry);
        }, $this->toArray());

        return $entries;
    }

    protected function serializeEntry($value)
    {
        return $value instanceof ArrayContainer ? $value->serialize() : $this->serializeObject($value);
    }

    protected function serializeObject($object)
    {
        return is_object($object) ? json_encode(json_decode($object), true) : $object;
    }
}