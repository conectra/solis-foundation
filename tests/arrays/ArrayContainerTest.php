<?php

namespace Solis\Foundation;

use Solis\Foundation\Arrays\ArrayContainer;
use PHPUnit\Framework\TestCase;

class ArrayContainerTest extends TestCase
{
    private $date;
    private $time;
    private $year;

    public function testCanGetEntry()
    {
        $container = $this->getArrayContainerForTest();
        $this->assertNotInternalType('null', $container->get('date'), 'Method can\'t return a valid entry');
    }

    public function testEntryHasExpectedValue()
    {
        $container = $this->getArrayContainerForTest();
        $this->assertEquals($this->date, $container->get('date'), 'Cannot obtain expected value in container entry');
    }

    public function testCanSetEntry()
    {
        $container = $this->getArrayContainerForTest();
        $container->set('year', $this->year);
        $this->assertEquals($this->year, $container->get('year'), 'Cannot set entry in array container');
    }

    private function getArrayContainerForTest()
    {
        $this->date = Date('Y-m-d');
        $this->time = Date('H-i-s');
        $this->year = Date('Y');

        return new ArrayContainer([
                'date' => $this->date,
                'time' => $this->time,
        ]);
    }
}