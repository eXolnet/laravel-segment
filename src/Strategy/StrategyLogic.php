<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Feature;

abstract class StrategyLogic extends Builder
{
    /**
     * @param \Exolnet\Bento\Feature $feature
     * @param callable $callback
     */
    public function __construct(Feature $feature, callable $callback)
    {
        parent::__construct($feature);

        $callback($this);
    }
}
