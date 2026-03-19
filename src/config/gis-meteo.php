<?php
return [
    'host' => env('GIS_METEO_HOST', 'https://api.gismeteo.net/v4/weather'),
    'auth' => [
        'token' => env('GIS_METEO_AUTH_TOKEN', ''),
    ],
    'cache_ttl' => env('GIS_METEO_CACHE_TTL', 3600), //3600*24
    'default_city' => env('GIS_METEO_CITY', 'Moscow'),
    'debug_data' => '{}'
];
