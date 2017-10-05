<?php
/**
 * This file is part of the Solis Components Package.
 *
 * (c) Rafael Becker <rafael@beecker.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Solis\Foundation\Closure;

/**
 * Interface FlowInterface
 *
 * @package Solis\Foundation\Closure
 */
interface FlowInterface
{
    /**
     * @return mixed
     */
    public function execute();

    /**
     * @param string $data
     *
     * @return mixed
     */
    public function get(string $data);

    /**
     * @param string $property
     * @param mixed  $value
     */
    public function set(string $property, $value);

    /**
     * @return \Closure
     */
    public function getAction(): \Closure;

    /**
     * @param \Closure $action
     */
    public function setAction($action);

    /**
     * @param \Closure $before
     */
    public function addBefore(\Closure $before);

    /**
     * @param \Closure $after
     */
    public function addAfter(\Closure $after);

    /**
     * @return array
     */
    public function getBeforeActionResult(): array;

    /**
     * @return array
     */
    public function getAfterActionResult(): array;

    /**
     * @param \Closure $closure
     */
    public function setExceptionHandler(\Closure $closure);
}
