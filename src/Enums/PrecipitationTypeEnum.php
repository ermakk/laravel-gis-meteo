<?php

namespace Ermakk\GisMeteo\Enums;

enum PrecipitationTypeEnum: int
{
    case NONE = 0;
    case RAIN = 1;
    case SNOW = 2;
    case RAIN_AND_SNOW = 3;


    public function toString(): ?string
    {
        return match($this) {
            self::NONE => 'отсутствие осадков',
            self::RAIN => 'дождь',
            self::SNOW => 'снег',
            self::RAIN_AND_SNOW => 'дождь со снегом',
        };
    }

}
