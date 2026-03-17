<?php

namespace Ermakk\GisMeteo\Helpers;

use Ermakk\GisMeteo\DTOs\Wind as WinDTO;

class Wind
{
    public static function createDTO(float $degrees): WinDTO
    {
        return WinDTO::fromDegrees($degrees);
    }

    public static function mapCollection(array $windDegreesArray): \Illuminate\Support\Collection
    {
        return collect($windDegreesArray)->map(fn($degrees) => self::createDTO($degrees));
    }

    // Совместимость с предыдущим кодом
    public static function getWindDirection(float $degrees): string
    {
        return WinDTO::fromDegrees($degrees)->direction;
    }

    public static function getWindDirectionShort(float $degrees): string
    {
        return WinDTO::fromDegrees($degrees)->shortDirection;
    }

    public static function getWindDirectionFull(float $degrees): string
    {
        return WinDTO::fromDegrees($degrees)->fullDirection;
    }
}
