<?php

namespace Exolnet\Bento\Tests\Integration;

use Exolnet\Bento\Facades\Bento;
use Exolnet\Bento\Feature;
use Exolnet\Bento\Strategy\Builder;
use Exolnet\Bento\Strategy\Strategy;
use Exolnet\Bento\Strategy\Stub;
use Exolnet\Bento\Tests\TestCase;

class SyntaxTest extends TestCase
{
    /**
     * @return void
     */
    public function testBasic(): void
    {
        $feature = Bento::feature('basic')
            ->everyone();

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
    }

    /**
     * @return void
     */
    public function testAndSyntax(): void
    {
        $feature = Bento::feature('and')
            ->user()
            ->date('2020-01-01', '>=');

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(2, $feature->countStrategies());
    }

    /**
     * @return void
     */
    public function testAndSyntaxAlternative(): void
    {
        $feature = Bento::feature('and')->logicAnd(function (Builder $aim) {
            $aim
                ->environment(['local', 'testing'])
                ->date('2020-01-01');
        });

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
    }

    /**
     * @return void
     */
    public function testOrSyntax(): void
    {
        $feature = Bento::feature('or')->logicOr(function (Builder $aim) {
            $aim
                ->environment(['local', 'testing'])
                ->date('2020-01-01');
        });

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
    }

    /**
     * @return void
     */
    public function testNotSyntax(): void
    {
        $feature = Bento::feature('not')->logicNot(function (Builder $aim) {
            $aim->environment('production');
        });

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
    }

    /**
     * @return void
     */
    public function testCallback(): void
    {
        $feature = Bento::feature('callback')->callback(function () {
            return true;
        });

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
    }

    /**
     * @return void
     */
    public function testCallable(): void
    {
        $feature = Bento::feature('callback')
            ->callback(new class {
                /**
                 * @return bool
                 */
                public function __invoke(): bool
                {
                    return true;
                }
            });

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
    }

    /**
     * @return void
     */
    public function testCustomStrategy(): void
    {
        $feature = Bento::feature('custom')
            ->aim(new Stub(true));

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
    }

    /**
     * @return void
     */
    public function testCustomAnonymousStrategy(): void
    {
        $feature = Bento::feature('custom')
            ->aim(new class implements Strategy {
                /**
                 * @return bool
                 */
                public function __invoke(): bool
                {
                    return true;
                }
            });

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
    }

    /**
     * @return void
     */
    public function testComplexStrategy(): void
    {
        $feature = Bento::feature('complex')->logicOr(function (Builder $aim) {
            $aim
                ->environment(['local', 'testing'])
                ->logicAnd(function (Builder $aim) {
                    $aim
                        ->environment('production')
                        ->date('2020-01-01', '>=');
                });
        });

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(1, $feature->countStrategies());
    }
}
