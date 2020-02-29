# Laravel Bento

[![Latest Stable Version](https://poser.pugx.org/eXolnet/laravel-bento/v/stable?format=flat-square)](https://packagist.org/packages/eXolnet/laravel-bento)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/eXolnet/laravel-bento/master.svg?style=flat-square)](https://travis-ci.org/eXolnet/laravel-bento)
[![StyleCI](https://github.styleci.io/repos/98363972/shield?branch=master)](https://github.styleci.io/repos/98363972)
[![Total Downloads](https://img.shields.io/packagist/dt/eXolnet/laravel-bento.svg?style=flat-square)](https://packagist.org/packages/eXolnet/laravel-bento)

Bento helps you organize feature launches by custom user segments.
Create and organize rules to make features available to certain users.

Define your features, define your segmentation strategies and let Bento launch each feature to the right people. Bento can also help you run A/B testing on your applications. 

The core concepts of this library are inspired by [Airbnb's Trebuchet](https://github.com/airbnb/trebuchet) project for Ruby.

## Installation

Require this package with composer:

```
composer require eXolnet/laravel-bento
```

If you don't use package auto-discovery, add the service provider to the ``providers`` array in `config/app.php`:

```
Exolnet\Bento\BentoServiceProvider::class
```

And the facade to the ``facades`` array in `config/app.php`: 

```
'Bento' => Exolnet\Bento\Facades\Bento::class
```

## Usage

### Create Features

Define features and their launch segmentation strategies. You can define a feature with the `feature` method:

```
Bento::feature('feature')->visitorPercent(10);
```

Or you can combine multiple strategies:

```
Bento::feature('feature')
    ->visitorPercent(10)
    ->hostname('example.com');
```

Your features could be grouped in the `boot` method of a service provider:

```php
<?php

namespace App\Providers;

use Exolnet\Bento\Facades\Bento;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        Bento::feature('foo')->everyone();
        Bento::feature('bar')->everyone();
    }
}
```

### Launch Your Features

You can check if a feature is launched for a visitor with the `launch` method:

```
if (Bento::launch('feature')) {
    //
}
```

Or check that a feature is awaiting launch:

```
if (Bento::await('feature')) {
    //
}
```

#### Blade

In Blade templates, handy macros are also available:

```
@launch('feature')
    Feature is launched!
@else
    Coming soon!
@endlaunch
```

```
@await('feature')
    Coming soon!
@else
    Feature is launched!
@endawait
```

#### Middleware

Since some strategy requires the request context to be evaluated, it's recommended to use middleware to limit a route:

1. Add the following middleware in the `$routeMiddleware` of your application's HTTP Kernel:

```
    protected $routeMiddleware = [
        // ...
        'await' => \Exolnet\Bento\Middleware\Await::class,
        'launch' => \Exolnet\Bento\Middleware\Launch::class,
        // ...
    ];
```

2. Then, you could use them to restrict your routes:

```
Route::middleware('launch:feature')->group(function () {
    //
});
```

```
Route::middleware('await:feature')->group(function () {
    //
});
```

### Basic Segmentation Strategies

The following segmentation strategies are available to help quickly target your users:

* Callback
* Config
* Date
* Environment
* Everyone
* Guest
* Hostname 
* Nobody
* Stub
* User (authenticated or specific user IDs)
* User Percent (a fraction of all connected visitors)
* Visitor Percent (a fraction of all your visitors)

### Logic Segmentation Strategies

Additional logic segmentation strategies are available to help target your users with more complex rules.

#### Logic Not

```php
use \Exolnet\Bento\Strategy\Builder;

Bento::feature('feature')
    ->logicNot(function(Builder $aim) {
        $aim->everyone();
    });
```

#### Logic And

```php
use \Exolnet\Bento\Strategy\Builder;

Bento::feature('feature')
    ->logicAnd(function(Builder $aim) {
        $aim
            ->environment('production')
            ->visitorPercent(20);
    });
});
```

#### Logic Or

```php
use \Exolnet\Bento\Strategy\Builder;

Bento::feature('feature')
    ->logicOr(function(Builder $aim) {
        $aim
            ->environment(['local', 'staging'])
            ->user([1, 2]);
    });
});
```

### Custom Segmentation Strategies

You can create your own custom strategies:

```php
use \Exolnet\Bento\Strategy\Strategy;

Bento::feature('feature')
    ->aim(new class implements Strategy {
        /**
         * @return bool
         */
        public function __invoke(): bool
        {
            return true;
        }
    });
```

## Testing

To run the PHPUnit tests, please use:

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE OF CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email security@exolnet.com instead of using the issue tracker.

## Credits

- [Alexandre D'Eschambeault](https://github.com/xel1045)
- [Airbnb Trebuchet](https://github.com/airbnb/trebuchet)
- [All Contributors](../../contributors)

## License

This code is licensed under the [MIT license](http://choosealicense.com/licenses/mit/). Please see the [license file](LICENSE) for more information.
