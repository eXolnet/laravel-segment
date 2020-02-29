<?php

namespace Exolnet\Bento\Strategy;

class Nobody extends StrategyBase
{
    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        return false;
    }
}
