<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Date;
use Exolnet\Bento\Tests\TestCase;
use Generator;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

class DateTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('2020-01-01')
        );
    }

    /**
     * @return void
     */
    public function testInvalidOperator(): void
    {
        $strategy = new Date('2020-01-01', 'invalid');

        $this->expectException(InvalidArgumentException::class);
        $strategy->launch();
    }

    /**
     * @return void
     * @dataProvider provideTestLaunch
     */
    public function testLaunch($date, $operator, $expected): void
    {
        $strategy = new Date($date, $operator);

        $actual = $strategy->launch();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return \Generator
     */
    public function provideTestLaunch(): Generator
    {
        yield ['2019-12-31', '<', true];
        yield ['2020-01-01', '<', false];
        yield ['2020-01-02', '<', false];

        yield ['2019-12-31', '<=', true];
        yield ['2020-01-01', '<=', true];
        yield ['2020-01-02', '<=', false];

        yield ['2019-12-31', '>=', false];
        yield ['2020-01-01', '>=', true];
        yield ['2020-01-02', '>=', true];

        yield ['2019-12-31', '>', false];
        yield ['2020-01-01', '>', false];
        yield ['2020-01-02', '>', true];

        yield ['2019-12-31', '=', false];
        yield ['2020-01-01', '=', true];
        yield ['2020-01-02', '=', false];
    }
}
