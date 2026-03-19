<?php

namespace Ermakk\GisMeteo\Http;

use Ermakk\GisMeteo\DTOs\Forecast;
use Ermakk\GisMeteo\DTOs\Weather;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\PendingRequest;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class ForecastRequest extends Request implements HasBody, Cacheable
{
    use HasJsonBody;
    use HasCaching;

    protected Method $method = Method::GET;
    protected ?string $restFormat = 'json';
    protected string $city = 'Moscow';
    protected ?string $locate = 'ru-RU';
    protected bool $debug = false;

    public function resolveCacheDriver(): Driver
    {
        return new LaravelCacheDriver(cache()->driver());
    }

    protected function cacheKey(PendingRequest $pendingRequest): ?string
    {
        $day = now()->format('Y-m-d');
        $hour = now()->hour;
        return "gis-meteo.request.$this->city.day.$day.hour.$hour";
    }
    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        return config('gis-meteo.endpoints.forecast.h1', '/forecast/h1');
    }

    protected function defaultHeaders(): array
    {
        return [
            'X-Gismeteo-Token' => config('gis-meteo.auth.token', '')
        ];
    }

    public function debugMode(): self
    {
        $this->debug = true;
        return $this;
    }
    public function setCity(string $name):self
    {
        $this->city = $name;
        return $this;
    }
    public function setLocate(string $locate):self
    {
        $this->locate = $locate;
        return $this;
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        if($this->debug){
            $data = json_decode(config('gis-meteo.debug_data', '{}'), true);
        } else {
            $data = $response->json();
        }

        return new Weather($data['location'], $data['forecast'], $data['astronomy']);
    }
    public function await(array $params = [])
    {
        foreach ($params as $key => $param){
            if(!is_null($param)) $this->query()->add($key, $param);
        }
        $this->query()->add('name', $this->city)->add('locate', $this->locate ?? app()->getLocale());
        $result = (new GisMeteoConnector())->send($this);
        try {
            $result->throw();
            return $result;
        } catch (\Exception $exception){
            logger($exception);
            return null;
        }

    }

    /**
     * Define the cache expiry in seconds
     */
    public function cacheExpiryInSeconds(): int
    {
        return config('gis-meteo.cache_ttl', 3600);
    }
}
