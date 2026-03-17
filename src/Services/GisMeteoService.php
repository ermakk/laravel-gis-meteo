<?php

namespace Ermakk\GisMeteo\Services;

use Ermakk\GisMeteo\DTOs\Weather;
use Illuminate\Support\Facades\Cache;
use Ermakk\GisMeteo\Http\GisMeteoConnector;
use Ermakk\GisMeteo\Http\ForecastRequest;
use Ermakk\GisMeteo\DTOs\Forecast;

class GisMeteoService
{
    protected GisMeteoConnector $connector;
    protected int $cacheTtl = 86400;
    protected string $city = 'Moscow';

    public function __construct(int $cacheTtl)
    {
        $this->connector = new GisMeteoConnector();
    }

    public function setCacheTtl(int $cacheTtl): self
    {
         $this->cacheTtl = $cacheTtl;
         return $this;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getWeather(): Weather
    {
        $city = $city ?? config('gis-meteo.default_city', 'Moscow');
        $day = now()->format('Y-m-d');
        // Создаем уникальный ключ для кэширования
        $cacheKey = "gis-meteo.weather.$city.day.$day";
        try {
            if(config('gis-meteo.debug', false)) {
                $request = new ForecastRequest($city);
                $response = $this->connector->send($request->debugMode());
                return $response->dto();
            }
            return Cache::remember($cacheKey, $this->cacheTtl, function () use ($city) {
                $request = new ForecastRequest($city);
                $response = $this->connector->send($request);
                if($response->status() === 200) {
                    return $response->dto();
                } else {
                    throw new \Exception('Произошла ошибка при запросе на GisMeteo');
                }
                return $response->dto();
            });
        } catch($e) {
            return $e;
        }
    }

    // Метод для очистки кэша для конкретного города
    public function clearCache(string $city = null): void
    {
        $city = $city ?: $this->city;
        $day = now()->format('Y-m-d');
        $cacheKey = "gis-meteo.weather.$city.day.$day";
        Cache::forget($cacheKey);
    }

    // Метод для получения времени жизни кэша
    public function getCacheTtl(): int
    {
        return $this->cacheTtl;
    }
    // Метод для получения города
    public function getCity(): string
    {
        return $this->city;
    }
}
