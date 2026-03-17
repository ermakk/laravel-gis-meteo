<?php

namespace Ermakk\GisMeteo\DTOs;

use Ermakk\GisMeteo\Helpers\PrecipitationIntensity;
use Ermakk\GisMeteo\Helpers\PrecipitationType;
use Ermakk\GisMeteo\Helpers\Cloudiness;
use Ermakk\GisMeteo\Helpers\PollenBirch;
use Ermakk\GisMeteo\Helpers\PollenGrass;
use Ermakk\GisMeteo\Helpers\Wind;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Forecast
{
    public Collection $windDirection;
    public Collection $precipitationIntensity;
    public Collection $precipitationType;
    public Collection $cloudinessLabels;
    public Collection $pollenBirch;
    public Collection $pollenGrass;

    public function __construct(
        public array|Collection $time,
        public array $temperature_air,
        public array $temperature_water,
        public array $precipitation_type,
        public array $pressure,
        public array $storm_prediction,
        public array $cloudiness,
        public array $humidity,
        public array $icon_weather,
        public array $description,
        public array|null $dew_point = null,
        public array|null $temperature_heat_index = null,
        public array|null $precipitation = null,
        public array|null $precipitation_intensity = null,
        public array|null $precipitation_probability = null,
        public array|null $wind_direction = null,
        public array|null $wind_speed = null,
        public array|null $wind_gust = null,
        public array|null $snow_height = null,
        public array|null $snow_fall = null,
        public array|null $pollen_birch = null,
        public array|null $pollen_grass = null,
        public array|null $radiation = null,
        public array|null $road_condition_code = null
    )
    {
        // Инициализация коллекций с преобразованием
        $this->time = collect($time)->map(fn($item) => new Carbon($item));
        $this->windDirection = collect($wind_direction ?? [])->map(fn($deg) => Wind::getWindDirection($deg));
        $this->precipitationIntensity = PrecipitationIntensity::mapCollection($this->precipitation_intensity);
        $this->precipitationType = PrecipitationType::mapCollection($this->precipitation_type);
        $this->cloudinessLabels = Cloudiness::mapCollection($cloudiness ?? []);
        $this->pollenBirch = PollenBirch::mapCollection($pollen_birch ?? []);
        $this->pollenGrass = PollenGrass::mapCollection($this->pollen_grass ?? []);
        $this->windDirection = Wind::mapCollection($this->wind_direction ?? []);
    }

    /**
     * Преобразует в массив (для сериализации)
     */
    public function toArray(): array
    {
        return [
            'time' => $this->time->toArray(),
            'temperature_air' => $this->temperature_air,
            'temperature_heat_index' => $this->temperature_heat_index,
            'temperature_water' => $this->temperature_water,
            'precipitation' => $this->precipitation,
            'precipitation_type' => $this->precipitation_type,
            'precipitationType' => $this->precipitationType->toArray(),
            'precipitation_intensity' => $this->precipitation_intensity,
            'precipitationIntensity' => $this->precipitationIntensity->toArray(),
            'precipitation_probability' => $this->precipitation_probability,
            'pressure' => $this->pressure,
            'storm_prediction' => $this->storm_prediction,
            'wind_direction' => $this->wind_direction,
            'windDirection' => $this->windDirection->toArray(),
            'wind_speed' => $this->wind_speed,
            'wind_gust' => $this->wind_gust,
            'cloudiness' => $this->cloudiness,
            'humidity' => $this->humidity,
            'dew_point' => $this->dew_point,
            'snow_height' => $this->snow_height,
            'snow_fall' => $this->snow_fall,
            'icon_weather' => $this->icon_weather,
            'description' => $this->description,
            'pollen_birch' => $this->pollen_birch,
            'radiation' => $this->radiation,
            'road_condition_code' => $this->road_condition_code,
        ];
    }
}
