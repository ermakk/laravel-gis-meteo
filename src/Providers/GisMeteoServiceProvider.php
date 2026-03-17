<?php
namespace Ermakk\GisMeteo\Providers;

use Ermakk\GisMeteo\Facades\Weather;
use Ermakk\GisMeteo\Services\GisMeteoService;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class GisMeteoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/gis-meteo.php', 'gis-meteo');

        $this->app->singleton(GisMeteoService::class, function ($app) {
            return new GisMeteoService(
                config('gis-meteo.cache_ttl')
            );
        });

        // Также регистрируем с именем класса для удобства
        $this->app->singleton(Weather::class, GisMeteoService::class);
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/gis-meteo.php' => config_path('gis-meteo.php'),
            ], 'config');
        }

        // Публикация иконок
        $this->publishes([
            __DIR__.'/../resources/views/icons' => resource_path('views/vendor/gis-meteo/icons'),
        ], 'icons');

        // Загрузка views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'gis-meteo');
        $this->loadViewsFrom(resource_path('views/vendor/gis-meteo'), 'gis-meteo');
    }
}
