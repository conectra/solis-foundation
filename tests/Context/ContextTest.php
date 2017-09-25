<?php
/**
 * This file is part of the Solis Components Package.
 *
 * (c) Rafael Becker <rafael@beecker.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Solis\Foundation\Tests\Context;

use PHPUnit\Framework\TestCase;
use Solis\Foundation\Context\Context;
use Solis\Foundation\Context\DomainReport;

class AbstractContextTest extends TestCase
{
    private $context;

    public function setUp()
    {
        $this->context = new Context([
             'name' => 'DummyContext',
         ], function () {
            $report = new DomainReport();
            $report->addErrorMessage('some error message');

            return $report;
        });
    }

    public function testCanGetEntryFromContext()
    {
        $this->assertEquals(
            'DummyContext',
            $this->context->get('name'),
            'Can\'t get name entry from Context data'
        );
    }

    public function testReturnNullWhenNotFoundContextEntry()
    {
        $this->assertInternalType(
            'null',
            $this->context->get(uniqid()),
            'Can\'t get null as expected when not found context entry'
        );
    }

    public function testCanSetEntryInContext()
    {
        $date  = Date('Y-m-d');
        $entry = 'random_' . $date;
        $this->context->set($entry, $date);
        $this->assertEquals(
            $date,
            $this->context->get($entry),
            'Can\'t get expected value when setting context entry'
        );
    }

    public function testReturnFalseIfContextIsInvalid()
    {
        $this->context->setValid(false);

        $this->assertEquals(
            false,
            $this->context->isValid(),
            'Can\'t get false as expected when context is invalid'
        );
    }

    public function testReturnTrueIfContextIsValid()
    {
        $this->context->setValid(true);

        $this->assertEquals(
            true,
            $this->context->isValid(),
            'Can\'t get true as expected when context is valid'
        );
    }

    public function testCanSetDomainClosure()
    {
        $this->context->setDomain(function () {
            return new DomainReport();
        });

        $this->assertInternalType(
            'callable',
            $this->context->getDomain(),
            'Domain is not of instance of internal type closure as expected'
        );
    }


    public function testContextIsInvalidWhenDomainReportHasErrors()
    {
        $this->context->setDomain(function () {
            $report = new DomainReport();
            $report->addErrorMessage('some error message');

            return $report;
        });

        $this->context->validate();
        $this->assertEquals(false, $this->context->isValid(), 'Context invalid state has not been set');
    }

    public function testContextIsValidWhenDomainReportHasNoErrors()
    {
        $this->context->setDomain(function () {
            $report = new DomainReport();

            return $report;
        });

        $this->context->validate();
        $this->assertEquals(true, $this->context->isValid(), 'Context valid state has not been set');
    }
}
