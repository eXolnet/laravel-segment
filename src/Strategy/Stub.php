<?php

namespace Exolnet\Bento\Strategy;

class Stub extends StrategyBase
{
    /**
     * @var bool
     */
    protected $state;

    /**
     * @param bool $state
     */
    public function __construct(bool $state)
    {
        $this->state = $state;
    }

    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        return $this->state;
    }
}
