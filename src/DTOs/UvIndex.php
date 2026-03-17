<?php

namespace Ermakk\GisMeteo\DTOs;

class UvIndex
{
    public function __construct(
        public int $index,
        public string $level,
        public string $description,
        public string $color,
        public string $protectionAdvice
    ) {}

    public static function fromIndex(int $index): self
    {
        return new self(
            index: $index,
            level: self::getLevel($index),
            description: self::getDescription($index),
            color: self::getColor($index),
            protectionAdvice: self::getProtectionAdvice($index)
        );
    }

    protected static function getLevel(int $index): string
    {
        if ($index >= 0 && $index <= 2) {
            return 'низкий';
        } elseif ($index >= 3 && $index <= 5) {
            return 'умеренный';
        } elseif ($index >= 6 && $index <= 7) {
            return 'высокий';
        } elseif ($index >= 8 && $index <= 10) {
            return 'очень высокий';
        } elseif ($index >= 11) {
            return 'экстремальный';
        }

        return 'неопределен';
    }

    protected static function getDescription(int $index): string
    {
        $level = self::getLevel($index);

        switch ($level) {
            case 'низкий':
                return 'Низкий уровень УФ-излучения (0-2)';
            case 'умеренный':
                return 'Умеренный уровень УФ-излучения (3-5)';
            case 'высокий':
                return 'Высокий уровень УФ-излучения (6-7)';
            case 'очень высокий':
                return 'Очень высокий уровень УФ-излучения (8-10)';
            case 'экстремальный':
                return 'Экстремальный уровень УФ-излучения (11+)';
            default:
                return 'Нет данных об УФ-индексе';
        }
    }

    protected static function getColor(int $index): string
    {
        $level = self::getLevel($index);

        switch ($level) {
            case 'низкий':
                return 'green';
            case 'умеренный':
                return 'yellow';
            case 'высокий':
                return 'orange';
            case 'очень высокий':
                return 'red';
            case 'экстремальный':
                return 'purple';
            default:
                return 'gray';
        }
    }

    protected static function getProtectionAdvice(int $index): string
    {
        $level = self::getLevel($index);

        switch ($level) {
            case 'низкий':
                return 'Минимальный риск. Обычная одежда и солнцезащитный крем при длительном пребывании на солнце.';
            case 'умеренный':
                return 'Умеренный риск. Наденьте солнцезащитные очки и используйте SPF 30+ при продолжительном пребывании на солнце.';
            case 'высокий':
                return 'Высокий риск. Наденьте солнцезащитные очки, используйте SPF 30+, избегайте пребывания на солнце в полдень.';
            case 'очень высокий':
                return 'Очень высокий риск. Защита обязательна! Наденьте солнцезащитные очки, используйте SPF 30+, избегайте солнца с 10 до 16 часов.';
            case 'экстремальный':
                return 'Экстремальный риск! Минимизируйте пребывание на солнце. Используйте SPF 50+, солнцезащитные очки, головной убор и одежду, закрывающую тело.';
            default:
                return 'Нет данных об УФ-индексе';
        }
    }

    public function toArray(): array
    {
        return [
            'index' => $this->index,
            'level' => $this->level,
            'description' => $this->description,
            'color' => $this->color,
            'protection_advice' => $this->protectionAdvice
        ];
    }
}
