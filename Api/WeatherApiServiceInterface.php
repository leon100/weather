<?php
declare(strict_types=1);

namespace Leon\Weather\Api;

interface WeatherApiServiceInterface
{

    /**
     * @return string
     */
    public function getWeather(): string;
}
