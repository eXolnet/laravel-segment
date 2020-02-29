<?php

namespace Exolnet\Bento\Tests\Unit;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\Stub;
use Exolnet\Bento\StrategyFactory;
use Exolnet\Bento\Tests\TestCase;
use Mockery as m;

class FeatureTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface|\Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @var \Exolnet\Bento\Feature
     */
    protected $feature;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->bento = m::mock(Bento::class);
        $this->feature = new Feature('name');
    }

    /**
     * @return void
     */
    public function testFeatureIsInstantiable(): void
    {
        $this->assertInstanceOf(Feature::class, $this->feature);
    }

    /**
     * @return void
     */
    public function testFeatureHasNoStrategiesByDefault(): void
    {
        $this->assertEmpty($this->feature->getStrategies());
        $this->assertEquals(0, $this->feature->countStrategies());
        $this->assertFalse($this->feature->hasStrategies());
    }

    /**
     * @return void
     */
    public function testFeatureIsNotLaunchWithoutStrategy(): void
    {
        $this->assertFalse($this->feature->launch());
    }

    /**
     * @return void
     */
    public function testFeatureAimIsFluent(): void
    {
        $factory = m::mock(StrategyFactory::class);
        $this->instance(StrategyFactory::class, $factory);

        $factory->shouldReceive('make')->with($this->feature, 'everyone')->andReturn(new Stub(true));

        $actual = $this->feature->everyone();

        $this->assertSame($this->feature, $actual);
    }

    /**
     * @return void
     */
    public function testAddStrategiesToFeature(): void
    {
        $factory = m::mock(StrategyFactory::class);
        $this->instance(StrategyFactory::class, $factory);

        $stub = new Stub(false);
        $factory->shouldReceive('make')->with($this->feature, 'nobody')->andReturn($stub);

        $this->feature->nobody();

        $strategies = $this->feature->getStrategies();

        $this->assertCount(1, $strategies);
        $this->assertEquals(1, $this->feature->countStrategies());
        $this->assertTrue($this->feature->hasStrategies());

        $this->assertSame($stub, $strategies[0]);
    }

    /**
     * @return void
     */
    public function testAddStrategiesThroughMethodCall(): void
    {
        $stub = new Stub(true);

        $factory = m::mock(StrategyFactory::class);
        $this->instance(StrategyFactory::class, $factory);

        $factory->shouldReceive('make')->with($this->feature, 'visitorPercent', 10)->andReturn($stub);

        $this->feature->visitorPercent(10);

        $strategies = $this->feature->getStrategies();

        $this->assertCount(1, $strategies);
        $this->assertEquals(1, $this->feature->countStrategies());
        $this->assertTrue($this->feature->hasStrategies());

        $this->assertSame($stub, $strategies[0]);
    }
}
