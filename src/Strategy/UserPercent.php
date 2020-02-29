<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Feature;
use Illuminate\Contracts\Auth\Factory as Auth;

class UserPercent extends StrategyPercent
{
    /**
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     * @param \Exolnet\Bento\Feature $feature
     * @param int $percent
     */
    public function __construct(Feature $feature, Auth $auth, $percent)
    {
        parent::__construct($feature, $percent);

        $this->auth = $auth;
    }

    /**
     * @return int|null
     */
    public function getUniqueId(): ?int
    {
        return $this->auth->guard()->id();
    }
}
