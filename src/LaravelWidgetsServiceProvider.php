<?php

namespace SchuBu\LaravelWidgets;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use SchuBu\LaravelWidgets\Console\MakeWidget;

class LaravelWidgetsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-widgets');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-widgets');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        Blade::directive('widget', function ($expression) {
            $name = trim($expression, "'");
            return "<?= resolve('App\Http\Widgets\\{$name}')->loadView(); ?>";
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-widgets.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-widgets'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-widgets'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-widgets'),
            ], 'lang');*/

            // Registering package commands.
             $this->commands([
                MakeWidget::class
             ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-widgets');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-widgets', function () {
            return new LaravelWidgets;
        });
    }
}
