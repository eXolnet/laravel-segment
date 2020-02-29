<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Callback;
use Exolnet\Bento\Tests\TestCase;
use Generator;

class CallbackTest extends TestCase
{
    /**
     * @return void
     * @dataProvider provideTestLaunch
     */
    public function testLaunch($expected): void
    {
        $strategy = new Callback(function () use ($expected) {
            return $expected;
        });

        $actual = $strategy->launch();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return \Generator
     */
    public function provideTestLaunch(): Generator
    {
        yield [true];
        yield [false];
    }
}
