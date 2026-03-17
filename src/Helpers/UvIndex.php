<?php

namespace Ermakk\GisMeteo\Helpers;

use Ermakk\GisMeteo\DTOs\UvIndex as UvIndexDTO;

class UvIndex
{
    public static function createDTO(int $index): UvIndexDTO
    {
        return UvIndexDTO::fromIndex($index);
    }

    public static function mapCollection(array $uvIndexArray): \Illuminate\Support\Collection
    {
        return collect($uvIndexArray)->map(fn($index) => self::createDTO($index));
    }
}
