<?php

namespace Ermakk\GisMeteo\Helpers;

use Ermakk\GisMeteo\DTOs\PollenBirch as PollenBirchDTO;

class PollenBirch
{
    public static function createDTO(int $count): PollenBirchDTO
    {
        return PollenBirchDTO::fromCount($count);
    }

    public static function mapCollection(array $pollenArray): \Illuminate\Support\Collection
    {
        return collect($pollenArray)->map(fn($count) => self::createDTO($count));
    }
}
