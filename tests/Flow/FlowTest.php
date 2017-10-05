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
use Solis\Foundation\Closure\FlowInterface;

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
        $flow->setAction(function (FlowInterface $flow) use ($expected) {
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
        $flow->setAction(function (FlowInterface $flow) use ($expected) {
            return $expected;
        });

        $expected = 'before closure';
        $flow->addBefore(function (FlowInterface $flow) use ($expected) {
            return $expected;
        });
        $flow->addBefore(function (FlowInterface $flow) use ($expected) {
            return $expected;
        });

        $flow->execute();
        $this->assertCount(2, $flow->getBeforeActionResult(), 'can\'t call before closure result');
    }

    public function testCanGetAfterActionClosureResult()
    {
        $flow     = new Flow();
        $expected = 'hello world!';
        $flow->setAction(function (FlowInterface $flow) use ($expected) {
            return $expected;
        });

        $expected = 'after closure';
        $flow->addAfter(function (FlowInterface $flow) use ($expected) {
            return $expected;
        });
        $flow->addAfter(function (FlowInterface $flow) use ($expected) {
            return $expected;
        });

        $flow->execute();
        $this->assertCount(2, $flow->getAfterActionResult(), 'can\'t get after closure result');
    }

    public function testCanShareDataBetweenClosures()
    {

        $shared = 'hoje';

        $flow = new Flow();
        $flow->setAction(function (FlowInterface $flow) use ($shared) {

            $flow->set('shared', $shared);
        });

        $flow->addAfter(function (FlowInterface $flow) use ($shared) {

            return $flow->get('shared');
        });

        $flow->execute();

        $after = $flow->getAfterActionResult();

        $this->assertEquals($shared, $after[0], 'can\'t share data between closures');
    }

    public function testCanSetSharedDataAfterInstantiateFlow()
    {
        $shared = [
                'shared' => uniqid(),
        ];

        $flow = new Flow();
        $flow->setAction(function () {

            return true;
        });
        $flow->addAfter(function (FlowInterface $flow) {

            return $flow->get('shared');
        });

        $flow->addShared($shared);

        $flow->execute();

        $after = $flow->getAfterActionResult();

        $this->assertEquals($shared['shared'], $after[0], 'can\'t share data between closures');
    }

    public function testCanCallExceptionHandlerMethod()
    {

        $shared = 'hoje';

        $flow = new Flow();
        $flow->setAction(function (FlowInterface $flow) use ($shared) {

            $flow->set('shared', $shared);
        });

        $flow->addAfter(function (FlowInterface $flow) use ($shared) {

            return $flow->get('day');
        });

        $flow->setExceptionHandler(function (FlowInterface $flow, \Exception $e) {

            return $e->getMessage();
        });

        $result = $flow->execute();

        $this->assertInternalType('string', $result, 'can\'t call excpetion handler');
    }
}
