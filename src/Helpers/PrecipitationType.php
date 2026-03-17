<?php

namespace Ermakk\GisMeteo\Helpers;

use Ermakk\GisMeteo\DTOs\PrecipitationType as PrecipitationTypeDTO;

class PrecipitationType
{
    public static function createDTO(int $code): PrecipitationTypeDTO
    {
        return PrecipitationTypeDTO::fromCode($code);
    }

    public static function mapCollection(array $codesArray): \Illuminate\Support\Collection
    {
        return collect($codesArray)->map(fn($code) => self::createDTO($code));
    }

    // Совместимость с предыдущими методами
    public static function getType(int $code): string
    {
        return PrecipitationTypeDTO::fromCode($code)->type;
    }

    public static function getDescription(int $code): string
    {
        return PrecipitationTypeDTO::fromCode($code)->description;
    }

    public static function getSymbol(int $code): string
    {
        return PrecipitationTypeDTO::fromCode($code)->symbol;
    }

    public static function getColor(int $code): string
    {
        return PrecipitationTypeDTO::fromCode($code)->color;
    }
}
