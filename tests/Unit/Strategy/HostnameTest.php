<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Hostname;
use Exolnet\Bento\Tests\TestCase;
use Generator;
use Illuminate\Http\Request;
use Mockery as m;

class HostnameTest extends TestCase
{
    /**
     * @param string|array $hosts
     * @param string $actualHost
     * @param bool $expectedLaunch
     * @return void
     * @dataProvider provideTestLaunch
     */
    public function testLaunch($hosts, string $actualHost, bool $expectedLaunch): void
    {
        $request = m::mock(Request::class);

        $strategy = new Hostname($request, $hosts);

        $request->shouldReceive('getHost')->once()->andReturn($actualHost);

        $actualLaunch = $strategy->launch();

        $this->assertEquals($expectedLaunch, $actualLaunch);
    }

    /**
     * @return \Generator
     */
    public function provideTestLaunch(): Generator
    {
        yield ['localhost', 'localhost', true];
        yield ['localhost', 'bento.dev', false];

        yield [['localhost', 'bento.dev'], 'localhost', true];
        yield [['localhost', 'bento.dev'], 'bento.dev', true];
        yield [['localhost', 'bento.dev'], 'bento.test', false];
    }
}
