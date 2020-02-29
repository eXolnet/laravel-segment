<?php

namespace Exolnet\Bento\Tests\Integration;

use BadMethodCallException;
use Exolnet\Bento\Facades\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Tests\TestCase;

class FeatureTest extends TestCase
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->bento = Bento::getFacadeRoot();
    }

    /**
     * @return void
     */
    public function testCreateNewFeature(): void
    {
        $feature = $this->bento->feature('name');

        $this->assertInstanceOf(Feature::class, $feature);
    }

    /**
     * @return void
     */
    public function testFeatureAimFluent(): void
    {
        $feature = $this->bento->feature('name')->visitorPercent(10);

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertCount(1, $feature->getStrategies());
    }

    /**
     * @return void
     */
    public function testFeatureAim(): void
    {
        $feature = $this->bento->feature('name')->visitorPercent(10);

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertCount(1, $feature->getStrategies());
    }

    /**
     * @return void
     */
    public function testLaunchFeatureDefault(): void
    {
        $launch = $this->bento->launch('name');

        $this->assertFalse($launch);
    }

    /**
     * @return void
     */
    public function testInvalidAim(): void
    {
        $this->expectException(BadMethodCallException::class);

        $this->bento->feature('name')->invalid();
    }
}
