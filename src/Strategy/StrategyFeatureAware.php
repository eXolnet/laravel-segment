<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Feature;

interface StrategyFeatureAware extends Strategy
{
    /**
     * @return \Exolnet\Bento\Feature
     */
    public function getFeature(): Feature;
}
