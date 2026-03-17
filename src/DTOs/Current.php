<?php

namespace Ermakk\GisMeteo\DTOs;

use Ermakk\GisMeteo\Helpers\PrecipitationIntensity;
use Ermakk\GisMeteo\DTOs\PrecipitationIntensity as PrecipitationIntensityDTO;
use Ermakk\GisMeteo\Helpers\PrecipitationType;
use Ermakk\GisMeteo\DTOs\PrecipitationType as PrecipitationTypeDTO;
use Ermakk\GisMeteo\Helpers\Cloudiness;
use Ermakk\GisMeteo\DTOs\Cloudiness as CloudinessDTO;
use Ermakk\GisMeteo\Helpers\PollenBirch;
use Ermakk\GisMeteo\DTOs\PollenBirch as PollenBirchDTO;
use Ermakk\GisMeteo\Helpers\PollenGrass;
use Ermakk\GisMeteo\DTOs\PollenGrass as PollenGrassDTO;
use Ermakk\GisMeteo\Helpers\Wind;
use Ermakk\GisMeteo\DTOs\Wind as WinDTO;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Current
{
    public ?WinDTO $windDirection;
    public ?PrecipitationIntensityDTO $precipitationIntensity;
    public ?PrecipitationTypeDTO $precipitationType;
    public ?CloudinessDTO $cloudinessLabel;
    public ?PollenBirchDTO $pollenBirch;
    public ?PollenGrassDTO $pollenGrass;

    public function __construct(
        public string|Carbon $time,
        public int $temperature_air,
        public int $temperature_water,
        public int $precipitation_type,
        public int $pressure,
        public bool $storm_prediction,
        public int $cloudiness,
        public int $humidity,
        public string $icon_weather,
        public string $description,
        public int|null $precipitation_probability = null,
        public int|null $dew_point = null,
        public int|null $temperature_heat_index = null,
        public int|null $precipitation = null,
        public int|null $precipitation_intensity = null,
        public int|null $wind_direction = null,
        public int|null $wind_speed = null,
        public int|null $wind_gust = null,
        public int|null $snow_height = null,
        public int|null $snow_fall = null,
        public int|null $pollen_birch = null,
        public int|null $pollen_grass = null,
        public int|null $radiation = null,
        public int|null $road_condition_code = null
    )
    {

        // Инициализация коллекций с преобразованием
        $this->time = collect($time)->map(fn($item) => new Carbon($item));
        $this->precipitationIntensity = PrecipitationIntensity::createDTO($this->precipitation_intensity);
        $this->precipitationType = PrecipitationType::createDTO($this->precipitation_type);
        $this->cloudinessLabel = $cloudiness ? Cloudiness::createDTO($cloudiness) : null;
        $this->pollenBirch = $pollen_birch ? PollenBirch::createDTO($pollen_birch) : null;
        $this->pollenGrass = $pollen_grass ? PollenGrass::createDTO($pollen_grass) : null;
        $this->windDirection = $wind_direction ? Wind::createDTO($wind_direction) : null;
    }

    /**
     * Преобразует в массив (для сериализации)
     */
    public function toArray(): array
    {
        return [
            'time' => $this->time,
            'temperature_air' => $this->temperature_air,
            'temperature_heat_index' => $this->temperature_heat_index,
            'temperature_water' => $this->temperature_water,
            'precipitation' => $this->precipitation,
            'precipitation_type' => $this->precipitation_type,
            'precipitationType' => $this->precipitationType,
            'precipitation_intensity' => $this->precipitation_intensity,
            'precipitationIntensity' => $this->precipitationIntensity,
            'precipitation_probability' => $this->precipitation_probability,
            'pressure' => $this->pressure,
            'storm_prediction' => $this->storm_prediction,
            'wind_direction' => $this->wind_direction,
            'windDirection' => $this->windDirection,
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
