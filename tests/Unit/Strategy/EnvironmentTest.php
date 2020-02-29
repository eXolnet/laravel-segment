<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Environment;
use Exolnet\Bento\Tests\TestCase;
use Generator;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Mockery as m;

class EnvironmentTest extends TestCase
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
     * @param string|array $environments
     * @param string $actualEnvironment
     * @param bool $expectedLaunch
     * @return void
     * @dataProvider provideTestLaunch
     */
    public function testLaunch($environments, string $actualEnvironment, bool $expectedLaunch): void
    {
        $strategy = new Environment($this->config, $environments);

        $this->config->shouldReceive('get')->with('app.env')->once()->andReturn($actualEnvironment);

        $actualLaunch = $strategy->launch();

        $this->assertEquals($expectedLaunch, $actualLaunch);
    }

    /**
     * @return \Generator
     */
    public function provideTestLaunch(): Generator
    {
        yield ['local', 'local', true];
        yield ['local', 'production', false];

        yield [['local', 'testing'], 'local', true];
        yield [['local', 'testing'], 'testing', true];
        yield [['local', 'testing'], 'production', false];
    }
}
