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

use Solis\Foundation\Arrays\ArrayCollection;

class DomainReport
{

    protected $erros;

    public function __construct()
    {
        $this->erros = new ArrayCollection();
    }

    public function errors()
    {
        return $this->erros->toArray();
    }

    public function addErrorMessage(string $message)
    {
        $this->erros->add(['message' => $message]);
    }
}