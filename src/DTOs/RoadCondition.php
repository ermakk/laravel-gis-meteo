<?php

namespace Ermakk\GisMeteo\DTOs;

class RoadCondition
{
    public function __construct(
        public int $code,
        public string $condition,
        public string $description,
        public string $color,
        public string $drivingAdvice
    ) {}

    public static function fromCode(int $code): self
    {
        return new self(
            code: $code,
            condition: self::getCondition($code),
            description: self::getDescription($code),
            color: self::getColor($code),
            drivingAdvice: self::getDrivingAdvice($code)
        );
    }

    protected static function getCondition(int $code): string
    {
        $conditions = [
            0 => 'Нет данных',
            1 => 'Сухая дорога',
            2 => 'Мокрая дорога',
            3 => 'Лед/снег на дороге',
            4 => 'Смесь воды и снега',
            5 => 'Роса',
            6 => 'Тающий снег',
            7 => 'Мороз',
            8 => 'Ледяной дождь'
        ];

        return $conditions[$code] ?? 'Неизвестное состояние';
    }

    protected static function getDescription(int $code): string
    {
        $descriptions = [
            0 => 'Нет данных о состоянии дорожного покрытия',
            1 => 'Сухая дорога - нормальные условия движения',
            2 => 'Мокрая дорога - скользкие условия, требуется осторожность',
            3 => 'Лед/снег на дороге - опасные условия, возможны заносы',
            4 => 'Смесь воды и снега на дороге - скользкие и непредсказуемые условия',
            5 => 'Роса - легкое увлажнение дорожного покрытия',
            6 => 'Тающий снег - переменные условия, местами скользко',
            7 => 'Мороз - возможен гололед, осторожное вождение',
            8 => 'Ледяной дождь - крайне опасные условия, максимальная осторожность'
        ];

        return $descriptions[$code] ?? 'Неизвестное состояние дорожного покрытия';
    }

    protected static function getColor(int $code): string
    {
        $colors = [
            0 => 'gray',      // Нет данных
            1 => 'green',     // Сухая дорога
            2 => 'blue',      // Мокрая дорога
            3 => 'red',       // Лед/снег
            4 => 'orange',    // Смесь воды и снега
            5 => 'lightblue', // Роса
            6 => 'lightgray', // Тающий снег
            7 => 'cyan',      // Мороз
            8 => 'darkred'    // Ледяной дождь
        ];

        return $colors[$code] ?? 'gray';
    }

    protected static function getDrivingAdvice(int $code): string
    {
        $advices = [
            0 => 'Информация недоступна',
            1 => 'Нормальные условия вождения. Соблюдайте стандартные правила дорожного движения.',
            2 => 'Дорога мокрая. Уменьшите скорость, увеличьте дистанцию, избегайте резких маневров.',
            3 => 'Опасные дорожные условия! Сниженная сцепка с дорогой. Используйте зимнюю резину, ездите медленно и аккуратно.',
            4 => 'Скользкие условия. Возможны заносы. Используйте противобуксовочную систему, двигайтесь очень осторожно.',
            5 => 'Легкое увлажнение. Обычная осторожность достаточна, но будьте внимательны при торможении.',
            6 => 'Переменные условия. Местами скользко. Следите за изменением дорожного покрытия, адаптируйте скорость.',
            7 => 'Возможен гололед. Осторожное вождение обязательно. Проверьте работу обогревателей стекол.',
            8 => 'ЭКСТРЕМАЛЬНАЯ ОПАСНОСТЬ! Максимальная осторожность. По возможности не выезжайте на дорогу.'
        ];

        return $advices[$code] ?? 'Информация недоступна';
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'condition' => $this->condition,
            'description' => $this->description,
            'color' => $this->color,
            'driving_advice' => $this->drivingAdvice
        ];
    }
}
