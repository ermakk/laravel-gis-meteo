<?php

namespace Ermakk\GisMeteo\Enums;

enum PrecipitationIntensityEnum: int
{
    case NONE = 0;
    case SMALL = 1;
    case MIDDLE = 2;
    case HIGH = 3;


    public function toString(): ?string
    {
        return match($this) {
            self::NONE => 'Нет осадков',
            self::SMALL => 'Небольшой дождь/снег',
            self::MIDDLE => 'Дождь/снег',
            self::HIGH => 'Сильный дождь/снег',
        };
    }

}
