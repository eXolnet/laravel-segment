<?php

namespace Exolnet\Bento;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BentoServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Blade::directive('launch', function ($expression) {
            return "<?php if (\Exolnet\Bento\BentoFacade::launch($expression)): ?>";
        });

        Blade::directive('endlaunch', function () {
            return '<?php endif; ?>';
        });

        Blade::directive('unlesslaunch', function ($expression) {
            return "<?php if (\Exolnet\Bento\BentoFacade::pending($expression)): ?>";
        });

        Blade::directive('endunlesslaunch', function () {
            return '<?php endif; ?>';
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Bento::class);

        $this->app->alias(Bento::class, 'bento');
    }
}
