<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\User;
use Exolnet\Bento\Tests\TestCase;
use Illuminate\Contracts\Auth\Factory as Auth;
use Mockery as m;

class UserTest extends TestCase
{
    /**
     * @var \Illuminate\Contracts\Auth\Factory|\Mockery\MockInterface
     */
    protected $auth;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->auth = m::mock(Auth::class);
    }

    /**
     * @return void
     */
    public function testLaunchGuest(): void
    {
        $strategy = new User($this->auth);

        $this->auth->shouldReceive('guard->id')->once()->andReturn(null);

        $this->assertFalse($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchAuthenticated(): void
    {
        $strategy = new User($this->auth);

        $this->auth->shouldReceive('guard->id')->once()->andReturn(42);

        $this->assertTrue($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchInvalidIdFromInt(): void
    {
        $strategy = new User($this->auth, 100);

        $this->auth->shouldReceive('guard->id')->once()->andReturn(42);

        $this->assertFalse($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchInvalidIdFromArray(): void
    {
        $strategy = new User($this->auth, [100, 200]);

        $this->auth->shouldReceive('guard->id')->once()->andReturn(42);

        $this->assertFalse($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchValidIdFromInt(): void
    {
        $strategy = new User($this->auth, 42);

        $this->auth->shouldReceive('guard->id')->once()->andReturn(42);

        $this->assertTrue($strategy->launch());
    }

    /**
     * @return void
     */
    public function testLaunchValidIdFromArray(): void
    {
        $strategy = new User($this->auth, [42, 200]);

        $this->auth->shouldReceive('guard->id')->once()->andReturn(42);

        $this->assertTrue($strategy->launch());
    }
}
