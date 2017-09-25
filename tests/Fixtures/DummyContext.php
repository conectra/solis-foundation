<?php
/**
 * This file is part of the Solis Components Package.
 *
 * (c) Rafael Becker <rafael@beecker.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Solis\Foundation\Tests\Fixtures;

use Solis\Foundation\Context\AbstractContext;

class DummyContext extends AbstractContext
{

    public static function make()
    {
        $data = [
            'name' => 'DummyContext',
        ];

        return new static($data);
    }
}
