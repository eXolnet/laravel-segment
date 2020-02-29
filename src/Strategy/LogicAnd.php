<?php

namespace Exolnet\Bento\Strategy;

class LogicAnd extends StrategyLogic
{
    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        foreach ($this->getStrategies() as $strategy) {
            if (! $strategy()) {
                return false;
            }
        }

        return true;
    }
}
