<?php

namespace Ermakk\GisMeteo\Helpers;

use Ermakk\GisMeteo\DTOs\RoadCondition as RoadConditionDTO;

class RoadCondition
{
    public static function createDTO(int $code): RoadConditionDTO
    {
        return RoadConditionDTO::fromCode($code);
    }

    public static function mapCollection(array $codesArray): \Illuminate\Support\Collection
    {
        return collect($codesArray)->map(fn($code) => self::createDTO($code));
    }

    // Совместимость с предыдущими методами
    public static function getCondition(int $code): string
    {
        return RoadConditionDTO::fromCode($code)->condition;
    }

    public static function getDescription(int $code): string
    {
        return RoadConditionDTO::fromCode($code)->description;
    }

    public static function getColor(int $code): string
    {
        return RoadConditionDTO::fromCode($code)->color;
    }

    public static function getDrivingAdvice(int $code): string
    {
        return RoadConditionDTO::fromCode($code)->drivingAdvice;
    }
}
