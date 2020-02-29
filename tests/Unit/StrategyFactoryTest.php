<?php

namespace Exolnet\Bento\Tests\Unit;

use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\Callback;
use Exolnet\Bento\Strategy\Everyone;
use Exolnet\Bento\Strategy\Stub;
use Exolnet\Bento\Strategy\User;
use Exolnet\Bento\Strategy\UserPercent;
use Exolnet\Bento\StrategyFactory;
use Exolnet\Bento\Tests\TestCase;
use Illuminate\Container\Container;
use Illuminate\Contracts\Auth\Factory as Auth;
use InvalidArgumentException;
use Mockery as m;

class StrategyFactoryTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface|\Exolnet\Bento\Feature
     */
    protected $feature;

    /**
     * @var \Mockery\MockInterface|\Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Exolnet\Bento\StrategyFactory::__construct
     */
    protected $factory;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->feature = m::mock(Feature::class);
        $this->container = m::mock(Container::class);
        $this->factory = new StrategyFactory($this->container);
    }

    /**
     * @return void
     */
    public function testMakeStrategy(): void
    {
        $strategy = $this->factory->make($this->feature, 'everyone');

        $this->assertInstanceOf(Everyone::class, $strategy);
    }

    /**
     * @return void
     */
    public function testMakeInvalidStrategy(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->factory->make($this->feature, 'invalid');
    }

    /**
     * @return void
     */
    public function testMakeStrategyWithOptions(): void
    {
        /** @var \Exolnet\Bento\Strategy\Stub $strategy */
        $strategy = $this->factory->make($this->feature, 'stub', true);

        $this->assertInstanceOf(Stub::class, $strategy);
        $this->assertTrue($strategy->launch());
    }

    /**
     * @return void
     */
    public function testMakeWithDependencyInjection(): void
    {
        $auth = m::mock(Auth::class);

        $this->container->shouldReceive('make')->with(Auth::class)->andReturn($auth);

        /** @var \Exolnet\Bento\Strategy\User $strategy */
        $strategy = $this->factory->make($this->feature, 'user', [42]);

        $this->assertInstanceOf(User::class, $strategy);
    }

    /**
     * @return void
     */
    public function testMakeWithFeatureAware(): void
    {
        $auth = m::mock(Auth::class);

        $this->container->shouldReceive('make')->with(Auth::class)->andReturn($auth);

        /** @var \Exolnet\Bento\Strategy\UserPercent $strategy */
        $strategy = $this->factory->make($this->feature, 'user-percent', 42);

        $this->assertInstanceOf(UserPercent::class, $strategy);
        $this->assertSame($this->feature, $strategy->getFeature());
    }
}
