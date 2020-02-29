<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Guest;
use Exolnet\Bento\Tests\TestCase;
use Illuminate\Contracts\Auth\Factory as Auth;
use Mockery as m;

class GuestTest extends TestCase
{
    /**
     * @var \Illuminate\Contracts\Auth\Factory|\Mockery\MockInterface
     */
    protected $auth;

    /**
     * @var \Exolnet\Bento\Strategy\Guest
     */
    protected $strategy;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->auth = m::mock(Auth::class);

        $this->strategy = new Guest($this->auth);
    }

    /**
     * @return void
     */
    public function testLaunchGuest(): void
    {
        $this->auth->shouldReceive('guard->guest')->once()->andReturn(true);

        $this->assertTrue($this->strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchAuthenticated(): void
    {
        $this->auth->shouldReceive('guard->guest')->once()->andReturn(false);

        $this->assertFalse($this->strategy->launch());
    }
}
