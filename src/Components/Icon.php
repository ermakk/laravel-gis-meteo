<?php

namespace Ermakk\GisMeteo\Components;

use Illuminate\Support\Facades\Blade;
use Saloon\Traits\Makeable;
class Icon
{
    use Makeable;

    protected string $icon;
    protected array $attributes = [];
    public function render(?array $attributes = null): string
    {

        if (view()->exists("gis-meteo::icons.{$this->icon}")) {
            return view("gis-meteo::icons.{$this->icon}", [
                'attributes' => new \Illuminate\View\ComponentAttributeBag($attributes ?? $this->attributes),
                'forecast' => $this
            ])->render();
        }

        return '';
    }
}
