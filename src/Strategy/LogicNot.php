<?php

namespace Exolnet\Bento\Strategy;

class LogicNot extends LogicAnd
{
    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        return ! parent::__invoke();
    }
}
