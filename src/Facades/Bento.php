<?php

namespace Exolnet\Bento\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Exolnet\Bento\Bento
 *
 * @method \Exolnet\Bento\Feature feature(string $name)
 * @method bool launch(string $name)
 * @method bool await(string $name)
 * @method int getVisitorId()
 * @method void setVisitorId(int $visitorId)
 */
class Bento extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'bento';
    }
}
