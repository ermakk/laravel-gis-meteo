<?php

namespace Ermakk\GisMeteo\DTOs;

use Ermakk\GisMeteo\Helpers\GetCurrent;
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

    protected array $current = [];
    public function __construct(
        protected GetCurrent $data
    )
    {
        $this->current = $data->toArray();
    }

    /**
     * Преобразует в массив (для сериализации)
     */
    public function toArray(): array
    {
        return [
            'time' => new Carbon($this->current['time']),
            'temperature_air' => $this->current['temperature_air'],
            'temperature_heat_index' => $this->current['temperature_heat_index'],
            'temperature_water' => $this->current['temperature_water'],
            'precipitation' => $this->current['precipitation'],
            'precipitation_type' => $this->current['precipitation_type'],
            'precipitationType' => PrecipitationType::createDTO($this->current['precipitation_type']),
            'precipitation_intensity' => $this->current['precipitation_intensity'],
            'precipitationIntensity' => PrecipitationIntensity::createDTO($this->current['precipitation_intensity']),
            'precipitation_probability' => $this->current['precipitation_probability'],
            'pressure' => $this->current['pressure'],
            'storm_prediction' => $this->current['storm_prediction'],
            'wind_direction' => $this->current['wind_direction'],
            'windDirection' => $this->current['wind_direction'] ? Wind::createDTO($this->current['wind_direction']) : null,
            'wind_speed' => $this->current['wind_speed'],
            'wind_gust' => $this->current['wind_gust'],
            'cloudiness' => $this->current['cloudiness'],
            'cloudinessLabel' => $this->current['cloudiness'] ? Cloudiness::createDTO($this->current['cloudiness']) : null,
            'humidity' => $this->current['humidity'],
            'dew_point' => $this->current['dew_point'],
            'snow_height' => $this->current['snow_height'],
            'snow_fall' => $this->current['snow_fall'],
            'icon_weather' => $this->current['icon_weather'],
            'description' => $this->current['description'],
            'pollen_birch' => $this->current['pollen_birch'],
            'pollenBirch' => $this->current['pollen_birch'] ? PollenBirch::createDTO($this->current['pollen_birch']) : null,
            'pollenGrass' => $this->current['pollen_grass'] ? PollenGrass::createDTO($this->current['pollen_grass']) : null,
            'radiation' => $this->current['radiation'],
            'road_condition_code' => $this->current['road_condition_code'],
        ];
    }
}
