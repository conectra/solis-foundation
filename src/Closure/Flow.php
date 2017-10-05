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

use Solis\Foundation\Arrays\ArrayContainer;

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
     * @var ArrayContainer
     */
    private $data;

    /**
     * @var \Closure
     */
    private $onException;

    /**
     * Flow constructor.
     */
    public function __construct()
    {
        $this->data = ArrayContainer::make();
    }

    /**
     * @return mixed
     */
    public function execute()
    {

        try {

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

        } catch (\Exception $e) {
            return $this->callOnException($e);
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
     * @param array $shared
     */
    public function addShared(array $shared)
    {
        foreach ($shared as $field => $value) {
            $this->data->set($field, $value);
        }
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

    /**
     * @param \Closure $closure
     */
    public function setExceptionHandler(\Closure $closure)
    {
        $this->onException = $closure;
    }

    /**
     * @param string $data
     *
     * @return mixed|null
     */
    public function get(string $data)
    {
        $entry = $this->data->get($data);

        if (!$entry) {
            throw new \OutOfBoundsException("{$entry} is a invalid key for closure shared data");
        }

        return $entry;
    }

    /**
     * @param string $property
     * @param mixed  $value
     */
    public function set(string $property, $value)
    {
        $this->data->set($property, $value);
    }

    /**
     * @return bool
     */
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

        return $closure($this);
    }

    /**
     * @return bool
     */
    private function callBeforeActionClosure()
    {
        $count = 0;
        foreach ($this->before as $closure) {
            $result = $this->callClosure($closure);

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
            $result = $this->callClosure($closure);

            $this->afterResult[] = $result;

            $count++;
        }

        return $count === count($this->after);
    }

    /**
     * @param $closure
     *
     * @return mixed
     */
    private function callClosure($closure)
    {
        return $closure($this);
    }

    /**
     * @param \Exception $exception
     *
     * @return mixed
     * @throws \Exception
     */
    private function callOnException(\Exception $exception)
    {
        if (is_null($this->onException)) {
            throw  $exception;
        }

        $closure = $this->onException;

        $message = $closure($this, $exception);

        return $message;
    }
}
