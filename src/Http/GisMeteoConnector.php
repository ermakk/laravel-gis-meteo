<?php

namespace Ermakk\GisMeteo\Http;

use Saloon\Http\Connector;

class GisMeteoConnector extends Connector
{

    /**
     * @inheritDoc
     */
    public function resolveBaseUrl(): string
    {
        return config('gis-meteo.host', 'https://api.gismeteo.net/v4/weather');
    }


}
