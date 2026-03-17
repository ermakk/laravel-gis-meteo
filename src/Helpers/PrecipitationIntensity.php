<?php

namespace Ermakk\GisMeteo\Helpers;

use Ermakk\GisMeteo\DTOs\PrecipitationIntensity as PrecipitationIntensityDTO;

class PrecipitationIntensity
{
    public static function createDTO(int $code): PrecipitationIntensityDTO
    {
        return PrecipitationIntensityDTO::fromCode($code);
    }

    public static function mapCollection(array $codesArray): \Illuminate\Support\Collection
    {
        return collect($codesArray)->map(fn($code) => self::createDTO($code));
    }

    // Совместимость с предыдущими методами
    public static function getIntensity(int $code): string
    {
        return PrecipitationIntensityDTO::fromCode($code)->intensity;
    }

    public static function getDescription(int $code): string
    {
        return PrecipitationIntensityDTO::fromCode($code)->description;
    }

    public static function getColor(int $code): string
    {
        return PrecipitationIntensityDTO::fromCode($code)->color;
    }

    public static function getImpactLevel(int $code): string
    {
        return PrecipitationIntensityDTO::fromCode($code)->impactLevel;
    }

    public static function getRecommendation(int $code): string
    {
        return PrecipitationIntensityDTO::fromCode($code)->recommendation;
    }
}
