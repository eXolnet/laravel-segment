<?php

namespace Exolnet\Bento\Strategy;

interface Strategy
{
    /**
     * @return bool
     */
    public function __invoke(): bool;
}
