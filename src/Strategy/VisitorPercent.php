<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;

class VisitorPercent extends StrategyPercent
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @param \Exolnet\Bento\Bento $bento
     * @param \Exolnet\Bento\Feature $feature
     * @param int $percent
     */
    public function __construct(Bento $bento, Feature $feature, $percent)
    {
        parent::__construct($feature, $percent);

        $this->bento = $bento;
    }

    /**
     * @return int
     */
    public function getUniqueId(): ?int
    {
        return $this->bento->getVisitorId();
    }
}
