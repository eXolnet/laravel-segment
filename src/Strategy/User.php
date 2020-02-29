<?php

namespace Exolnet\Bento\Strategy;

use Illuminate\Contracts\Auth\Factory as Auth;

class User extends StrategyBase
{
    /**
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * @var array|null
     */
    protected $userIds;

    /**
     * @param \Illuminate\Contracts\Auth\Factory $auth
     * @param array|int|null $userIds
     */
    public function __construct(Auth $auth, $userIds = null)
    {
        $this->auth = $auth;

        if ($userIds) {
            $this->userIds = (array)$userIds;
        }
    }

    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        if (! $userId = $this->auth->guard()->id()) {
            return false;
        }

        // Launch the feature to any authenticated user.
        if (! is_array($this->userIds)) {
            return true;
        }

        return in_array($userId, $this->userIds);
    }
}
