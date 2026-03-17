<?php

namespace Ermakk\GisMeteo\DTOs;

class PrecipitationIntensity
{
    public function __construct(
        public int $code,
        public string $intensity,
        public string $description,
        public string $color,
        public string $impactLevel,
        public string $recommendation
    ) {}

    public static function fromCode(int $code): self
    {
        return new self(
            code: $code,
            intensity: self::getIntensity($code),
            description: self::getDescription($code),
            color: self::getColor($code),
            impactLevel: self::getImpactLevel($code),
            recommendation: self::getRecommendation($code)
        );
    }

    protected static function getIntensity(int $code): string
    {
        $intensities = [
            0 => 'Нет осадков',
            1 => 'Небольшой дождь/снег',
            2 => 'Дождь/снег',
            3 => 'Сильный дождь/снег'
        ];

        return $intensities[$code] ?? 'Неизвестная интенсивность';
    }

    protected static function getDescription(int $code): string
    {
        $descriptions = [
            0 => 'Осадки отсутствуют',
            1 => 'Слабая интенсивность осадков - небольшой дождь или снег',
            2 => 'Средняя интенсивность осадков - умеренный дождь или снег',
            3 => 'Высокая интенсивность осадков - сильный дождь или снег'
        ];

        return $descriptions[$code] ?? 'Неизвестная интенсивность осадков';
    }

    protected static function getColor(int $code): string
    {
        $colors = [
            0 => 'gray',      // Нет осадков
            1 => 'lightblue', // Небольшой дождь/снег
            2 => 'blue',      // Дождь/снег
            3 => 'darkblue'   // Сильный дождь/снег
        ];

        return $colors[$code] ?? 'gray';
    }

    protected static function getImpactLevel(int $code): string
    {
        $levels = [
            0 => 'Отсутствует',
            1 => 'Низкий',
            2 => 'Средний',
            3 => 'Высокий'
        ];

        return $levels[$code] ?? 'Неизвестный';
    }

    protected static function getRecommendation(int $code): string
    {
        $recommendations = [
            0 => 'Осадки отсутствуют. Никаких специальных мер не требуется.',
            1 => 'Небольшие осадки. Рекомендуется иметь при себе зонт или дождевик.',
            2 => 'Умеренные осадки. Необходимо использовать защиту от дождя/снега. Будьте осторожны на дорогах.',
            3 => 'Сильные осадки! По возможности избегать выход на улицу. Если необходимо выйти, используйте надежную защиту от осадков и соблюдайте осторожность на дорогах.'
        ];

        return $recommendations[$code] ?? 'Информация недоступна';
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'intensity' => $this->intensity,
            'description' => $this->description,
            'color' => $this->color,
            'impact_level' => $this->impactLevel,
            'recommendation' => $this->recommendation
        ];
    }
}
