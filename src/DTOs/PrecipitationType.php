<?php

namespace Ermakk\GisMeteo\DTOs;

class PrecipitationType
{
    public function __construct(
        public int $code,
        public string $type,
        public string $description,
        public string $symbol,
        public string $color,
    ) {}

    public static function fromCode(int $code): self
    {
        return new self(
            code: $code,
            type: self::getType($code),
            description: self::getDescription($code),
            symbol: self::getSymbol($code),
            color: self::getColor($code),
        );
    }

    protected static function getType(int $code): string
    {
        $types = [
            0 => 'Отсутствие осадков',
            1 => 'Дождь',
            2 => 'Снег',
            3 => 'Дождь со снегом'
        ];

        return $types[$code] ?? 'Неизвестный тип осадков';
    }

    protected static function getDescription(int $code): string
    {
        $descriptions = [
            0 => 'Атмосферные осадки отсутствуют',
            1 => 'Жидкие атмосферные осадки в виде капель воды',
            2 => 'Твердые кристаллические атмосферные осадки в виде снежинок',
            3 => 'Смешанные атмосферные осадки - дождь и снег одновременно'
        ];

        return $descriptions[$code] ?? 'Неизвестное описание типа осадков';
    }

    protected static function getSymbol(int $code): string
    {
        $symbols = [
            0 => '☀️',  // Солнце
            1 => '🌧️',  // Дождь
            2 => '❄️',  // Снег
            3 => '🌨️'   // Дождь со снегом
        ];

        return $symbols[$code] ?? '☁️'; // Облако по умолчанию
    }


    protected static function getColor(int $code): string
    {
        $colors = [
            0 => 'gray',      // Отсутствие осадков
            1 => 'blue',      // Дождь
            2 => 'white',     // Снег
            3 => 'lightblue'  // Дождь со снегом
        ];

        return $colors[$code] ?? 'gray';
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'type' => $this->type,
            'description' => $this->description,
            'symbol' => $this->symbol,
            'color' => $this->color,
        ];
    }
}
