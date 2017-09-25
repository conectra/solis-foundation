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
use Solis\Foundation\Context\DomainReport;

class DomainReportTest extends TestCase
{

    private $report;

    public function setUp()
    {
        $this->report = new DomainReport();
    }

    public function testCanGetErros()
    {
        $this->assertNotInternalType('null', $this->report->errors(), 'Can\'t return errors from report');
    }

    public function testCanAddErrorMessage()
    {
        $this->report->addErrorMessage('some error message here');
        $this->assertEquals(1, count($this->report->errors()), 'Can\'t add report error as expected');
    }

    public function testCanAddMultipleErrorMessages()
    {
        $this->report->addErrorMessage('some error message here');
        $this->report->addErrorMessage('some error message here');
        $this->report->addErrorMessage('some error message here');

        $this->assertEquals(3, count($this->report->errors()), 'Can\'t add multiple error messages as expected');
    }

    public function testErrorArrayHasMessageKey()
    {
        $this->report->addErrorMessage('some error message here');
        $error = $this->report->errors();
        $this->assertArrayHasKey('message', $error[0], 'Error array has not message key');
    }

    public function testErrorArrayHasExpectedMessage()
    {
        $this->report->addErrorMessage('some error message here');
        $error = $this->report->errors();
        $this->assertEquals('some error message here', $error[0]['message'], 'Error array has not expected message');
    }
}