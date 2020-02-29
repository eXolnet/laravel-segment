<?php

namespace Exolnet\Bento\Strategy;

class Everyone extends StrategyBase
{
    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        return true;
    }
}
