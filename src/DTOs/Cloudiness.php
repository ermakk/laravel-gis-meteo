<?php

namespace Ermakk\GisMeteo\DTOs;

class Cloudiness
{
    public function __construct(
        public int $percentage,
        public string $description,
        public int $level
    ) {}

    public static function fromPercentage(int $percentage): self
    {
        return new self(
            percentage: $percentage,
            description: self::getDescription($percentage),
            level: self::getLevel($percentage)
        );
    }

    protected static function getDescription(int $percentage): string
    {
        if ($percentage >= 0 && $percentage <= 25) {
            return 'Ясно';
        } elseif ($percentage >= 26 && $percentage <= 50) {
            return 'Малооблачно';
        } elseif ($percentage >= 51 && $percentage <= 75) {
            return 'Облачно';
        } elseif ($percentage >= 76 && $percentage <= 100) {
            return 'Пасмурно';
        }

        return 'Неопределено';
    }

    protected static function getLevel(int $percentage): int
    {
        if ($percentage >= 0 && $percentage <= 25) {
            return 0; // Ясно
        } elseif ($percentage >= 26 && $percentage <= 50) {
            return 1; // Малооблачно
        } elseif ($percentage >= 51 && $percentage <= 75) {
            return 2; // Облачно
        } elseif ($percentage >= 76 && $percentage <= 100) {
            return 3; // Пасмурно
        }

        return 0;
    }

    public function toArray(): array
    {
        return [
            'percentage' => $this->percentage,
            'description' => $this->description,
            'level' => $this->level
        ];
    }
}
