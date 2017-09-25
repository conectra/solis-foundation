<?php
/**
 * This file is part of the Solis Components Package.
 *
 * (c) Rafael Becker <rafael@beecker.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Solis\Foundation\Context;

use Solis\Foundation\Arrays\ArrayContainer;

class Context
{

    protected $data;

    protected $valid;

    protected $domain;

    protected $report;

    public function __construct(array $data, \Closure $call)
    {
        $this->data = ArrayContainer::make($data);

        $this->valid = false;
    }

    public function get(string $entry)
    {
        return $this->data->get($entry);
    }

    public function set(string $entry, $value)
    {
        $this->data->set($entry, $value);
    }

    public function setValid(bool $isValid)
    {
        $this->valid = $isValid;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function setDomain(\Closure $call)
    {
        $this->domain = $call;
    }

    public function getDomain() : \Closure
    {
        return $this->domain;
    }

    public function validate()
    {
        $this->callDomain($this->data);

        $this->setValid(!boolval($this->report->errors()));

        return $this->isValid();
    }

    protected function callDomain($args)
    {
        $call = $this->domain;

        $report = $call($args);
        if (! ($report instanceof DomainReport)) {
            throw new \UnexpectedValueException('Domain result is not of type Domain Report');
        }

        $this->report = $report;
    }
}
