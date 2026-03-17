<?php

namespace Ermakk\GisMeteo\DTOs;

class PollenBirch
{
    public function __construct(
        public int $count,
        public int $level,
        public string $description,
        public string $color
    ) {}

    public static function fromCount(int $count): self
    {
        return new self(
            count: $count,
            level: self::getLevel($count),
            description: self::getDescription($count),
            color: self::getColor($count)
        );
    }

    protected static function getLevel(int $count): int
    {
        if ($count >= 1 && $count <= 29) {
            return 1;
        } elseif ($count >= 30 && $count <= 199) {
            return 2;
        } elseif ($count >= 200 && $count <= 999) {
            return 3;
        } elseif ($count >= 1000 && $count <= 4999) {
            return 4;
        } elseif ($count >= 5000) {
            return 5;
        }

        return 0;
    }

    protected static function getDescription(int $count): string
    {
        $level = self::getLevel($count);

        switch ($level) {
            case 1:
                return 'Низкий уровень пыльцы березы (1 балл)';
            case 2:
                return 'Умеренный уровень пыльцы березы (2 балла)';
            case 3:
                return 'Высокий уровень пыльцы березы (3 балла)';
            case 4:
                return 'Очень высокий уровень пыльцы березы (4 балла)';
            case 5:
                return 'Экстремальный уровень пыльцы березы (5 баллов)';
            default:
                return 'Нет данных о пыльце березы';
        }
    }

    protected static function getColor(int $count): string
    {
        $level = self::getLevel($count);

        switch ($level) {
            case 1:
                return 'green';
            case 2:
                return 'yellow';
            case 3:
                return 'orange';
            case 4:
                return 'red';
            case 5:
                return 'purple';
            default:
                return 'gray';
        }
    }

    public function toArray(): array
    {
        return [
            'count' => $this->count,
            'level' => $this->level,
            'description' => $this->description,
            'color' => $this->color
        ];
    }
}
