<?php

namespace Exolnet\Bento\Tests\Integration;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Tests\TestCase;

class BentoTest extends TestCase
{
    /**
     * @return void
     */
    public function testIsSingleton(): void
    {
        $instance1 = $this->app->make(Bento::class);
        $instance2 = $this->app->make(Bento::class);

        $this->assertSame($instance1, $instance2);
    }

    /**
     * @return void
     */
    public function testAlias(): void
    {
        $instance = $this->app->make(Bento::class);
        $alias    = $this->app->make('bento');

        $this->assertSame($instance, $alias);
    }
}
