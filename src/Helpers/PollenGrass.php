<?php

namespace Ermakk\GisMeteo\Helpers;

use Ermakk\GisMeteo\DTOs\PollenGrass as PollenGrassDTO;

class PollenGrass
{
    public static function createDTO(int $count): PollenGrassDTO
    {
        return PollenGrassDTO::fromCount($count);
    }

    public static function mapCollection(array $pollenArray): \Illuminate\Support\Collection
    {
        return collect($pollenArray)->map(fn($count) => self::createDTO($count));
    }
}
