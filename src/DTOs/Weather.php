<?php

namespace Ermakk\GisMeteo\DTOs;

use Ermakk\GisMeteo\Helpers\GetCurrent;

class Weather
{
    public array $location;
    public array|Forecast $forecast;
    public array|Current $current;
    public array $astronomy;
    public function __construct(array $location, array|Forecast $forecast, array $astronomy)
    {
        $this->location = $location;
        $this->forecast = new Forecast(...$forecast);
        $this->current = (new Current(new GetCurrent($this->forecast)))->toArray();
        $this->astronomy = $astronomy;
    }
    /**
     * Преобразует в массив (для сериализации)
     */
    public function toArray(): array
    {
        return [
            'location' => $this->location,
            'forecast' => $this->forecast->toArray(),
            'current' => $this->current,
            'astronomy' => $this->astronomy
        ];
    }
}
