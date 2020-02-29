<?php

namespace Exolnet\Bento\Tests;

use Exolnet\Bento\BentoServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Get the service providers for the package.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [BentoServiceProvider::class];
    }
}
