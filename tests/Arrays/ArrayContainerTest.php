<?php

namespace Solis\Foundation\Tests\Arrays;

use Solis\Foundation\Arrays\ArrayContainer;
use PHPUnit\Framework\TestCase;

class ArrayContainerTest extends TestCase
{
    private $container;
    private $date;
    private $time;
    private $year;

    public function setUp()
    {
        $this->date = Date('Y-m-d');
        $this->time = Date('H-i-s');
        $this->year = Date('Y');

        $this->container = ArrayContainer::make([
            'date' => $this->date,
            'time' => $this->time,
        ]);
    }

    public function testCanGetEntry()
    {
        $this->assertNotInternalType('null', $this->container->get('date'), 'Method can\'t return a valid entry');
    }

    public function testEntryHasExpectedValue()
    {
        $this->assertEquals(
            $this->date,
            $this->container->get('date'),
            'Cannot obtain expected value in container entry'
        );
    }

    public function testCanSetEntry()
    {
        $this->container->set('year', $this->year);
        $this->assertEquals($this->year, $this->container->get('year'), 'Cannot set entry in array container');
    }

    public function testCanRemoveEntry()
    {
        $this->container->set('random', uniqid());
        $this->container->remove('random');

        $this->assertInternalType('null', $this->container->get('random'), 'Cannot remove entry in array container');
    }

    public function testCanGetKeys()
    {
        $this->assertInternalType('array', $this->container->keys(), 'Cannot get keys of the array container');
    }

    public function testCanGetValues()
    {
        $this->assertInternalType('array', $this->container->values(), 'Cannot get values of the array container');
    }

    public function testCanGetArray()
    {
        $this->assertInternalType('array', $this->container->toArray(), 'Cannot get internal array in container');
    }

    public function testCanGetArrayAsJson()
    {
        $isJson = boolval(json_encode(json_decode($this->container->toJson(), true)));
        $this->assertEquals(true, $isJson, 'Internal array has not a valid json representation');
    }
}
