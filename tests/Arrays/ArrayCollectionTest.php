<?php

namespace Solis\Foundation\Tests\Arrays;

use PHPUnit\Framework\TestCase;
use Solis\Foundation\Arrays\ArrayCollection;
use Solis\Foundation\Tests\Arrays\Dummy\DummyDataCollection;

class ArrayCollectionTest extends TestCase
{
    private $collection;
    private $data;

    public function setUp()
    {
        $this->data = (new DummyDataCollection())->getData();

        $this->collection = new ArrayCollection($this->data);
    }

    public function testIsNotNull()
    {
        $this->assertNotInternalType('null', $this->collection, 'Cannot instantiate ArrayCollection');
    }

    public function testHasExpectedCount()
    {
        $this->assertEquals(
            count($this->data),
            $this->collection->count(),
            'Collection has not the expected number of elements'
        );
    }

    public function testCanGetLastCollectionItem()
    {
        $last = $this->collection->last();
        $this->assertNotInternalType('null', $last, 'Cannot return last entry of the ArrayCollection');
    }

    public function testCanGetFirstCollectionItem()
    {
        $first = $this->collection->first();
        $this->assertNotInternalType('null', $first, 'Cannot return first entry of the ArrayCollection');
    }

    public function testCanGetEntryFromIndex()
    {
        $value = $this->collection->get(0);
        $this->assertNotInternalType('null', $value, 'Cannot return entry by index of the ArrayCollection');
    }

    public function testCanAddToCollection()
    {
        $count = $this->collection->count();
        $this->collection->add(['message' => 'some array']);
        $this->assertEquals($count + 1, $this->collection->count(), 'Cannot add array to collection');
    }

    public function testCanGetAsArray()
    {
        $this->assertInternalType(
            'array',
            $this->collection->toArray(),
            'Cannot get collection as internal type array');
    }
}
