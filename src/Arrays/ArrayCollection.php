<?php

namespace Solis\Foundation\Arrays;

class ArrayCollection
{

    private $collection = [];

    public function __construct($arrays = [])
    {
        if ($arrays) {
            $this->buildCollection($arrays);
        }
    }

    public function get($index)
    {
        return $this->collection[$index] ?? null;
    }

    public function last()
    {
        return $this->collection[count($this->collection) - 1] ?? null;
    }

    public function first()
    {
        return $this->collection[0] ?? null();
    }

    public function count()
    {
        return count($this->collection);
    }

    protected function buildCollection($data)
    {
        $collection = [];
        foreach ($data as $array) {
            $collection[] = ArrayContainer::make(is_array($array) ? $array : [$array]);
        }
        $this->collection = $collection;
    }
}