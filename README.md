# Laravel Bento

[![Latest Stable Version](https://poser.pugx.org/eXolnet/laravel-bento/v/stable?format=flat-square)](https://packagist.org/packages/eXolnet/laravel-bento)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/github/workflow/status/eXolnet/laravel-bento/tests?label=tests&style=flat-square)](https://github.com/eXolnet/laravel-bento/actions?query=workflow%3Atests)
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

After installing Bento, publish its example service provider to hold your feature definitions:

```bash
php artisan vendor:publish --tag=bento-provider
```

Then, add it to the `providers` array in `config/app.php`:

```
App\Providers\BentoServiceProvider::class
```

## Usage

### Create Features

Define features and their launch segmentation strategies. You can define one strategy with the `aim` method:

```
Bento::aim('feature', 'visitor-percent', 10);
```

Or you can combine multiple strategies:

```
Bento::feature('feature')->aim('visitor-percent', 10)->aim('hostname', 'example.com');
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

Since some strategy requires the request context to be evaluated, it's recommended to use the `Feature` middleware to limit a route:

1. Add the `Feature` middleware in the `$routeMiddleware` of your application's HTTP Kernel:

```
    protected $routeMiddleware = [
        // ...
        'launch' => \Exolnet\Bento\Middleware\Launch::class,
        // ...
    ];
```

2. Then, you could use it to restrict your routes:

```
Route::middleware('launch:feature')->group(function () {
    //
});
```

### Basic Segmentation Strategies

The following segmentation strategies are available to help quickly target your users:

* Date
* Environment
* Everyone
* Guest
* Hostname 
* Nobody
* User (authenticated or specific user IDs)
* User Percent (a fraction of all connected visitors)
* Visitor Percent (a fraction of all your visitors)

### Logic Segmentation Strategies

Additional logic segmentation strategies are available to help target your users with more complex rules.

#### Logic Not

```
Bento::aim('feature', 'logic-not', 'everybody');
```

#### Logic And

```
Bento::aim('feature', 'logic-and', function($feature) {
    $feature
        ->aim('environment', 'production')
        ->aim('visitor-percent', 20);
});
```

#### Logic Or

```
Bento::aim('feature', 'logic-or', function($feature) {
    $feature
        ->aim('environment', 'staging')
        ->aim('user', [1, 2]);
});
```

### Custom Segmentation Strategies

You can create your own custom strategies.

You can also inject dependencies the same way [Laravel Controllers' method injection](https://laravel.com/docs/5.4/controllers#dependency-injection-and-controllers) works. A common use-case for method injection is injecting the `Illuminate\Contracts\Auth\Guard` instance into your strategy to target users by property:

```
use Illuminate\Contracts\Auth\Guard;

Bento::defineStrategy('role', function(Guard $guard, $role) {
    return $guard->user() && $guard->user()->role === $role;
});
```

Then, you can use your custom strategy like the default one:

```
Bento::feature('feature')->aim('role', 'admin');
```


## Testing

To run the phpUnit tests, please use:

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
