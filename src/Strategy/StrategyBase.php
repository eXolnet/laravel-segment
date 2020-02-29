<?php

namespace Exolnet\Bento\Strategy;

abstract class StrategyBase implements Strategy
{
    /**
     * @return bool
     */
    public function launch(): bool
    {
        return $this();
    }

    /**
     * @return bool
     */
    public function await(): bool
    {
        return ! $this->launch();
    }
}
