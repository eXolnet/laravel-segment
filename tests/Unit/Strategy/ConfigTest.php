<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Config;
use Exolnet\Bento\Tests\TestCase;
use Generator;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Mockery as m;

class ConfigTest extends TestCase
{
    /**
     * @var \Illuminate\Contracts\Config\Repository|\Mockery\MockInterface
     */
    protected $config;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->config = m::mock(ConfigRepository::class);
    }

    /**
     * @return void
     * @dataProvider provideTestLaunch
     */
    public function testLaunch($expectedLaunch): void
    {
        $strategy = new Config($this->config, 'feature.key');

        $this->config->shouldReceive('get')->with('feature.key')->once()->andReturn($expectedLaunch);

        $actual = $strategy->launch();

        $this->assertEquals($expectedLaunch, $actual);
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
