<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\LogicNot;
use Exolnet\Bento\Tests\UnitTest;
use Mockery;

class LogicNotTest extends UnitTest
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @var \Exolnet\Bento\Feature
     */
    protected $feature;

    /**
     * @var \Exolnet\Bento\Strategy\LogicNot
     */
    protected $logicNot;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->bento = Mockery::mock(Bento::class);
        $this->feature = Mockery::mock(Feature::class);
    }

    /**
     * @return void
     * @test
     */
    public function testGetFeature(): void
    {
        $this->bento->shouldReceive('makeStrategy')->once()->andReturn(true);
        $this->logicNot = new LogicNot($this->bento, $this->feature, 'everyone');

        self::assertEquals($this->feature, $this->logicNot->getFeature());
    }
}
