<?php

namespace Exolnet\Bento\Tests\Integration;

use Exolnet\Bento\Facades\Bento;
use Exolnet\Bento\Tests\TestCase;
use Generator;
use Illuminate\Contracts\View\Factory;

class BladeTest extends TestCase
{
    /**
     * @param string $directive
     * @param bool $state
     * @return void
     * @dataProvider provideTestDirective
     */
    public function testDirective(string $directive, bool $state): void
    {
        Bento::feature('foo')->stub($state);

        $view = app(Factory::class)->file(__DIR__ .'/../Fixtures/'. $directive .'.blade.php');
        $html = $view->render();

        $expected = $state ? 'Launch' : 'Await';
        $this->assertContains($expected, $html);
        $this->assertNotContains('@', $html);
    }

    /**
     * @return \Generator
     */
    public function provideTestDirective(): Generator
    {
        yield ['launch', true];
        yield ['launch', false];
        yield ['await', true];
        yield ['await', false];
    }
}
