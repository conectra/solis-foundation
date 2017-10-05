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
 * Class Flow
 *
 * @package Solis\Foundation\Closure
 */
class Flow implements FlowInterface
{

    /**
     * @var \Closure
     */
    private $action;

    /**
     * @var \Closure[]
     */
    private $before = [];

    /**
     * @var array
     */
    private $beforeResult = [];

    /**
     * @var \Closure
     */
    private $after = [];

    /**
     * @var array
     */
    private $afterResult = [];

    /**
     * @return mixed
     */
    public function execute()
    {
        if (!$this->hasActionClosure()) {
            throw  new \RuntimeException('action closure not defined');
        }

        if ($this->hasBeforeActionClosure()) {
            $this->callBeforeActionClosure();
        }

        $response = $this->callActionClosure();

        if ($this->hasAfterActionClosure()) {
            $this->callAfterActionClosure();
        }

        return $response;
    }

    /**
     * @return \Closure
     */
    public function getAction(): \Closure
    {
        return $this->action;
    }

    /**
     * @param \Closure $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @param \Closure $before
     */
    public function addBefore(\Closure $before)
    {
        $this->before[] = $before;
    }

    /**
     * @param \Closure $after
     */
    public function addAfter(\Closure $after)
    {
        $this->after[] = $after;
    }

    /**
     * @return array
     */
    public function getBeforeActionResult(): array
    {
        return $this->beforeResult;
    }

    /**
     * @return array
     */
    public function getAfterActionResult(): array
    {
        return $this->afterResult;
    }

    private function hasActionClosure()
    {
        return !empty($this->action);
    }

    /**
     * @return bool
     */
    private function hasBeforeActionClosure()
    {
        return !empty($this->before);
    }

    /**
     * @return bool
     */
    private function hasAfterActionClosure()
    {
        return !empty($this->after);
    }

    /**
     * @return mixed
     */
    private function callActionClosure()
    {
        $closure = $this->getAction();

        return $closure();
    }

    /**
     * @return bool
     */
    private function callBeforeActionClosure()
    {
        $count = 0;
        foreach ($this->before as $closure) {
            $result = $closure();

            $this->beforeResult[] = $result;

            $count++;
        }

        return $count === count($this->before);
    }

    /**
     * @return bool
     */
    private function callAfterActionClosure()
    {
        $count = 0;
        foreach ($this->after as $closure) {
            $result = $closure();

            $this->afterResult[] = $result;

            $count++;
        }

        return $count === count($this->after);
    }
}
