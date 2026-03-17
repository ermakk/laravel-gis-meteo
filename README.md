# GisMeteo Weather Package for Laravel

Пакет для интеграции с API GisMeteo в Laravel приложениях. Предоставляет удобный доступ к данным о погоде с использованием современных DTO и системой кэширования.

## Особенности

- 🌤️ **Полные данные о погоде** - почасовой прогноз, текущая погода, астрономические данные
- 🔧 **Система помощников** - преобразование данных (направление ветра, облачность, УФ-индекс и др.)
- 💾 **Кэширование** - Кэширование данных для бережного использования лимита на запросы
- 🎨 **Поддержка иконок** - встроенные Blade компоненты для визуализации погоды
- 🚀 **Интеграция с Saloon** - надежная работа с HTTP запросами

## Установка

```bash
composer require ermakk/laravel-gis-meteo
```

## Публикация конфигурации

```bash
php artisan vendor:publish --provider="Ermakk\GisMeteo\Providers\GisMeteoServiceProvider" --tag=config
```
## Настройка .env
```
GIS_METEO_AUTH_TOKEN=your_gismeteo_api_token
GIS_METEO_CITY=Moscow
GIS_METEO_CACHE_TTL=86400
```

## Конфигурация
Файл конфигурации config/gis-meteo.php:
```php
return [
    'host' => env('GIS_METEO_HOST', 'https://api.gismeteo.net/v4/weather'),
    'auth' => [
        'token' => env('GIS_METEO_AUTH_TOKEN', ''),
    ],
    'cache_ttl' => env('GIS_METEO_CACHE_TTL', 86400), // 24 часа
    'default_city' => env('GIS_METEO_CITY', 'Moscow'),
    'debug_data' => '{}'
];
```

## Использование
```php

// Получение погоды для города по умолчанию
$weather = Weather::getWeather();

// Получение погоды для конкретного города
$weather = Weather::setCity('Saint Petersburg')->getWeather();

// Очистка кэша
Weather::clearCache('Moscow');
```

## Работа с данными
```php
// Получение данных о погоде
$weather = Weather::getWeather();

// Информация о местоположении
echo $weather->location['name']; // Название города

// Текущая погода
$current = $weather->current;
echo $current->temperature_air; // Температура
echo $current->description;     // Описание

// Направление ветра как DTO
$windDTO = $current->windDirection;
echo $windDTO->direction;        // "северный"
echo $windDTO->shortDirection;   // "С"

// Облачность
$cloudinessDTO = $current->cloudinessLabel;
echo $cloudinessDTO->description; // "Ясно", "Малооблачно" и т.д.

// Тип осадков
$precipitationTypeDTO = $current->precipitationType;
echo $precipitationTypeDTO->type;    // "Дождь", "Снег" и т.д.
echo $precipitationTypeDTO->symbol;  // Эмодзи символ

// Интенсивность осадков
$precipitationIntensityDTO = $current->precipitationIntensity;
echo $precipitationIntensityDTO->intensity;    // "Небольшой дождь/снег"
echo $precipitationIntensityDTO->recommendation; // Рекомендации
```
