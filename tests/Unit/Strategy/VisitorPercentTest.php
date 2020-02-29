<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\VisitorPercent;
use Exolnet\Bento\Tests\TestCase;
use Mockery as m;

class VisitorPercentTest extends TestCase
{
    /**
     * @var \Exolnet\Bento\Bento|\Mockery\MockInterface
     */
    protected $bento;

    /**
     * @var \Exolnet\Bento\Feature|\Mockery\MockInterface
     */
    protected $feature;

    /**
     * @var \Exolnet\Bento\Strategy\VisitorPercent
     */
    protected $strategy;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->bento = m::mock(Bento::class);
        $this->feature = m::mock(Feature::class);

        $this->strategy = new VisitorPercent($this->bento, $this->feature, 10);
    }

    /**
     * @return void
     */
    public function testVisitorIdIsRetrievedFromBento(): void
    {
        $this->bento->shouldReceive('getVisitorId')->andReturn(42);

        $actual = $this->strategy->getUniqueId();

        $this->assertEquals(42, $actual);
    }
}
