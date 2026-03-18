<?php

namespace Ermakk\GisMeteo\Helpers;

use Ermakk\GisMeteo\DTOs\Forecast;
use Ermakk\GisMeteo\Helpers\PrecipitationIntensity;
use Ermakk\GisMeteo\Helpers\PrecipitationType;
use Ermakk\GisMeteo\Helpers\Cloudiness;
use Ermakk\GisMeteo\Helpers\PollenBirch;
use Ermakk\GisMeteo\Helpers\PollenGrass;
use Ermakk\GisMeteo\Helpers\Wind;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class GetCurrent
{
    protected int $currentHour = 0;

    public function __construct(
        public Forecast $forecast
    )
    {
        $this->currentHour = Carbon::now()->hour;
    }

    /**
     * Преобразует в массив (для сериализации)
     */
    public function toArray(): array
    {
        return [
            'time' => $this->forecast->time[$this->currentHour] ?? null,
            'temperature_air' => $this->forecast->temperature_air[$this->currentHour] ?? null,
            'temperature_heat_index' => $this->forecast->temperature_heat_index[$this->currentHour] ?? null,
            'temperature_water' => $this->forecast->temperature_water[$this->currentHour] ?? null,
            'precipitation' => $this->forecast->precipitation[$this->currentHour] ?? null,
            'precipitation_type' => $this->forecast->precipitation_type[$this->currentHour] ?? null,
            'precipitationType' => $this->forecast->precipitationType[$this->currentHour] ?? null,
            'precipitation_intensity' => $this->forecast->precipitation_intensity[$this->currentHour] ?? null,
            'precipitationIntensity' => $this->forecast->precipitationIntensity[$this->currentHour] ?? null,
            'precipitation_probability' => $this->forecast->precipitation_probability[$this->currentHour] ?? null,
            'pressure' => $this->forecast->pressure[$this->currentHour] ?? null,
            'storm_prediction' => $this->forecast->storm_prediction[$this->currentHour] ?? null,
            'wind_direction' => $this->forecast->wind_direction[$this->currentHour] ?? null,
            'windDirection' => $this->forecast->windDirection[$this->currentHour] ?? null,
            'wind_speed' => $this->forecast->wind_speed[$this->currentHour] ?? null,
            'wind_gust' => $this->forecast->wind_gust[$this->currentHour] ?? null,
            'cloudiness' => $this->forecast->cloudiness[$this->currentHour] ?? null,
            'humidity' => $this->forecast->humidity[$this->currentHour] ?? null,
            'dew_point' => $this->forecast->dew_point[$this->currentHour] ?? null,
            'snow_height' => $this->forecast->snow_height[$this->currentHour] ?? null,
            'snow_fall' => $this->forecast->snow_fall[$this->currentHour] ?? null,
            'icon_weather' => $this->forecast->icon_weather[$this->currentHour] ?? null,
            'description' => $this->forecast->description[$this->currentHour] ?? null,
            'pollen_birch' => $this->forecast->pollen_birch[$this->currentHour] ?? null,
            'pollen_grass' => $this->forecast->pollen_grass[$this->currentHour] ?? null,
            'radiation' => $this->forecast->radiation[$this->currentHour] ?? null,
            'road_condition_code' => $this->forecast->road_condition_code[$this->currentHour] ?? null,
        ];
    }
}
