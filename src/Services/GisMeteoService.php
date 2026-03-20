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
    protected int $cacheTtl = 3600;
    protected ?string $city = null;

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
        // Создаем уникальный ключ для кэширования
        $day = now()->format('Y-m-d');
        $hour = now()->hour;
        $cacheKey = "gis-meteo.weather.$city.day.$day.hour.$hour";
        if(config('gis-meteo.debug', false)) {
            $request = new ForecastRequest();
            $response = $request->setCity($city)->debugMode()->await();
            return $response->dto();
        }
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($city) {
            $request = new ForecastRequest();
            $response = $request->setCity($city)->await();
            if($response->status() === 200) {
                return $response->dto();
            } else {
                throw new \Exception('Произошла ошибка при запросе на GisMeteo. Статус ответа: '.$response->status());
            }
        });
    }    

    // Метод для очистки кэша для конкретного города
    public function clearCache(string $city = null): void
    {
        $city = $city ?: $this->city;
        $day = now()->format('Y-m-d');
        $hour = now()->hour;
        $cacheKey = "gis-meteo.weather.$city.day.$day.hour.$hour";
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
