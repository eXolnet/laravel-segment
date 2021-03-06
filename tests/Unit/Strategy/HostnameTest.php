<?php

namespace Exolnet\Bento\Tests\Unit\Strategy;

use Exolnet\Bento\Strategy\Hostname;
use Exolnet\Bento\Tests\UnitTest;
use Illuminate\Http\Request;
use Mockery;

class HostnameTest extends UnitTest
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \Exolnet\Bento\Strategy\Hostname
     */
    protected $strategy;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->request = Mockery::mock(Request::class);

        $this->strategy = new Hostname($this->request, ['admin']);
    }

    /**
     * @return void
     * @test
     */
    public function testLaunchForValidHostname(): void
    {
        $this->request->shouldReceive('getHost')->once()->andReturn('admin');

        self::assertTrue($this->strategy->launch());
    }

    /**
     * @return void
     * @test
     */
    public function testLaunchForInvalidHostname(): void
    {
        $this->request->shouldReceive('getHost')->once()->andReturn('tester');

        self::assertfalse($this->strategy->launch());
    }
}
