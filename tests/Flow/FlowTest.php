<?php
/**
 * This file is part of the Solis Components Package.
 *
 * (c) Rafael Becker <rafael@beecker.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Solis\Foundation\Tests\Flow;

use Solis\Foundation\Closure\Flow;
use PHPUnit\Framework\TestCase;

/**
 * Class FlowTest
 *
 * @package Solis\Foundation\Tests\Flow
 */
class FlowTest extends TestCase
{

    public function testCanExecuteFlowActionClosure()
    {
        $flow     = new Flow();
        $expected = 'hello world!';
        $flow->setAction(function () use ($expected) {
            return $expected;
        });
        $this->assertEquals($expected, $flow->execute(), 'can\'t execute flow action as expected');
    }

    public function testThrownExceptionWhenExecuteWithoutAction()
    {
        $this->expectException('RuntimeException');
        (new Flow())->execute();
    }

    public function testCanGetBeforeActionClosureResult()
    {
        $flow     = new Flow();
        $expected = 'hello world!';
        $flow->setAction(function () use ($expected) {
            return $expected;
        });

        $expected = 'before closure';
        $flow->addBefore(function () use ($expected) {
            return $expected;
        });
        $flow->addBefore(function () use ($expected) {
            return $expected;
        });

        $flow->execute();
        $this->assertCount(2, $flow->getBeforeActionResult(), 'can\'t call before closure result');
    }

    public function testCanGetAfterActionClosureResult()
    {
        $flow     = new Flow();
        $expected = 'hello world!';
        $flow->setAction(function () use ($expected) {
            return $expected;
        });

        $expected = 'after closure';
        $flow->addAfter(function () use ($expected) {
            return $expected;
        });
        $flow->addAfter(function () use ($expected) {
            return $expected;
        });

        $flow->execute();
        $this->assertCount(2, $flow->getAfterActionResult(), 'can\'t get after closure result');
    }
}
