<?php

namespace Ermakk\GisMeteo\DTOs;

class Wind
{
    public function __construct(
        public float $degrees,
        public string $direction,
        public string $fullDirection,
        public string $shortDirection
    ) {}

    public static function fromDegrees(float $degrees): self
    {
        return new self(
            degrees: $degrees,
            direction: self::getDirection($degrees),
            fullDirection: self::getFullDirection($degrees),
            shortDirection: self::getShortDirection($degrees)
        );
    }

    protected static function getDirection(float $degrees): string
    {
        // Нормализуем значение в диапазон 0-360
        $degrees = fmod($degrees, 360);
        if ($degrees < 0) {
            $degrees += 360;
        }

        if (($degrees >= 337.6 && $degrees <= 360) || ($degrees >= 0 && $degrees <= 22.5)) {
            return 'северный';
        } elseif ($degrees > 22.5 && $degrees <= 67.5) {
            return 'северо-восточный';
        } elseif ($degrees > 67.5 && $degrees <= 112.5) {
            return 'восточный';
        } elseif ($degrees > 112.5 && $degrees <= 157.5) {
            return 'юго-восточный';
        } elseif ($degrees > 157.5 && $degrees <= 202.5) {
            return 'южный';
        } elseif ($degrees > 202.5 && $degrees <= 247.5) {
            return 'юго-западный';
        } elseif ($degrees > 247.5 && $degrees <= 292.5) {
            return 'западный';
        } elseif ($degrees > 292.5 && $degrees <= 337.5) {
            return 'северо-западный';
        }

        return 'северный'; // fallback
    }

    protected static function getFullDirection(float $degrees): string
    {
        $direction = self::getDirection($degrees);

        $descriptions = [
            'северный' => 'Северный ветер',
            'северо-восточный' => 'Северо-восточный ветер',
            'восточный' => 'Восточный ветер',
            'юго-восточный' => 'Юго-восточный ветер',
            'южный' => 'Южный ветер',
            'юго-западный' => 'Юго-западный ветер',
            'западный' => 'Западный ветер',
            'северо-западный' => 'Северо-западный ветер'
        ];

        return $descriptions[$direction] ?? 'Неопределенный ветер';
    }

    protected static function getShortDirection(float $degrees): string
    {
        $direction = self::getDirection($degrees);

        $shortCodes = [
            'северный' => 'С',
            'северо-восточный' => 'СВ',
            'восточный' => 'В',
            'юго-восточный' => 'ЮВ',
            'южный' => 'Ю',
            'юго-западный' => 'ЮЗ',
            'западный' => 'З',
            'северо-западный' => 'СЗ'
        ];

        return $shortCodes[$direction] ?? 'С';
    }

    public function toArray(): array
    {
        return [
            'degrees' => $this->degrees,
            'direction' => $this->direction,
            'full_direction' => $this->fullDirection,
            'short_direction' => $this->shortDirection
        ];
    }
}
