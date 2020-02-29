<?php

namespace Exolnet\Bento\Strategy;

class Callback extends StrategyBase
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        return call_user_func($this->callback);
    }
}
