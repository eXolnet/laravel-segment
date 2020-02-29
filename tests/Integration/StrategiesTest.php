<?php

namespace Exolnet\Bento\Tests\Integration;

use Exolnet\Bento\Facades\Bento;
use Exolnet\Bento\Strategy\Builder;
use Exolnet\Bento\Strategy\Strategy;
use Exolnet\Bento\Tests\TestCase;

class StrategiesTest extends TestCase
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
    public function testEveryoneStrategy(): void
    {
        $this->assertTrue($this->bento->feature('name1')->everyone()->launch());
    }

    /**
     * @return void
     */
    public function testLogicAndStrategy(): void
    {
        $this->assertTrue($this->bento->feature('name1')->logicAnd(function (Builder $aim) {
            $aim
                ->everyone()
                ->everyone();
        })->launch());

        $this->assertFalse($this->bento->feature('name2')->logicAnd(function (Builder $aim) {
            $aim
                ->nobody()
                ->everyone();
        })->launch());

        $this->assertFalse($this->bento->feature('name3')->logicAnd(function (Builder $aim) {
            $aim
                ->nobody()
                ->nobody();
        })->launch());
    }

    /**
     * @return void
     */
    public function testLogicOrStrategy(): void
    {
        $this->assertTrue($this->bento->feature('name1')->logicOr(function (Builder $aim) {
            $aim
                ->everyone()
                ->everyone();
        })->launch());

        $this->assertTrue($this->bento->feature('name2')->logicOr(function (Builder $aim) {
            $aim
                ->nobody()
                ->everyone();
        })->launch());

        $this->assertFalse($this->bento->feature('name3')->logicOr(function (Builder $aim) {
            $aim
                ->nobody()
                ->nobody();
        })->launch());
    }

    /**
     * @return void
     */
    public function testLogicNotStrategy(): void
    {
        $this->assertFalse($this->bento->feature('name1')->logicNot(function (Builder $aim) {
            $aim->everyone();
        })->launch());

        $this->assertTrue($this->bento->feature('name2')->logicNot(function (Builder $aim) {
            $aim->nobody();
        })->launch());
    }

    /**
     * @return void
     */
    public function testNobodyStrategy(): void
    {
        $this->assertFalse($this->bento->feature('name1')->nobody()->launch());
    }

    /**
     * @return void
     */
    public function testCustomStrategy(): void
    {
        $this->assertTrue(
            $this->bento
                ->feature('name1')
                ->aim(new class implements Strategy {
                    public function __invoke(): bool
                    {
                        return true;
                    }
                })
                ->launch()
        );

        $this->assertFalse(
            $this->bento
                ->feature('name2')
                ->aim(new class implements Strategy {
                    public function __invoke(): bool
                    {
                        return false;
                    }
                })
                ->launch()
        );
    }
}
