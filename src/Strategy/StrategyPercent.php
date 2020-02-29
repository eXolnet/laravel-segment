<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Feature;

abstract class StrategyPercent extends StrategyBase implements StrategyFeatureAware
{
    /**
     * @var int
     */
    protected $percent;

    /**
     * @var \Exolnet\Bento\Feature
     */
    protected $feature;

    /**
     * @param \Exolnet\Bento\Feature $feature
     * @param int $percent
     */
    public function __construct(Feature $feature, int $percent)
    {
        $this->feature = $feature;
        $this->percent = $percent;
    }

    /**
     * @return \eXolnet\Bento\Feature
     */
    public function getFeature(): Feature
    {
        return $this->feature;
    }

    /**
     * @return int
     */
    public function getPercent(): int
    {
        return $this->percent;
    }

    /**
     * @return int|null
     */
    abstract public function getUniqueId(): ?int;

    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        if (! $uniqueId = $this->getUniqueId()) {
            return false;
        }

        $uniqueNumber = crc32($this->getFeature()->getName() .'|'. $uniqueId);

        // Limit the unique ID between 1 and 100.
        $percentile = $uniqueNumber % 100 + 1;

        // Based on the calculated percentile, we identify if the user has access to the feature.
        return $percentile <= $this->getPercent();
    }
}
