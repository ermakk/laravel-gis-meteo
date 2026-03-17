<?php
namespace Ermakk\GisMeteo\Facades;

use Ermakk\GisMeteo\Services\GisMeteoService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Ermakk\GisMeteo\DTOs\Weather getWeather()
 * @method static void clearCache(string $city = null)
 * @method static int getCacheTtl()
 * @method static string getCity()
 *
 * @see \Ermakk\GisMeteo\Services\GisMeteoService
 */
class Weather extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GisMeteoService::class;
    }
}
