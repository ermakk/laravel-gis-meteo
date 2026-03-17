<?php

namespace Ermakk\GisMeteo\Helpers;

use Ermakk\GisMeteo\DTOs\Cloudiness as CloudinessDTO;

class Cloudiness
{
    public static function createDTO(int $percentage): CloudinessDTO
    {
        return CloudinessDTO::fromPercentage($percentage);
    }

    public static function mapCollection(array $cloudinessArray): \Illuminate\Support\Collection
    {
        return collect($cloudinessArray)->map(fn($percentage) => self::createDTO($percentage));
    }
}
