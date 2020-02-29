<?php

namespace Exolnet\Bento\Strategy;

class LogicOr extends StrategyLogic
{
    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        foreach ($this->getStrategies() as $strategy) {
            if ($strategy()) {
                return true;
            }
        }

        return false;
    }
}
