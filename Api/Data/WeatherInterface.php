<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Leon\Weather\Api\Data;

interface WeatherInterface
{

    const WEATHER_ID = 'weather_id';
    const WEATHER_DATA = 'weather_data';
    const CREATED_AT = 'created_at';

    /**
     * Get weather_id
     * @return string|null
     */
    public function getWeatherId();

    /**
     * Set weather_id
     * @param string $weatherId
     * @return \Leon\Weather\Weather\Api\Data\WeatherInterface
     */
    public function setWeatherId($weatherId);

    /**
     * Get weather_data
     * @return string|null
     */
    public function getWeatherData();

    /**
     * Set weather_data
     * @param string $weatherData
     * @return \Leon\Weather\Weather\Api\Data\WeatherInterface
     */
    public function setWeatherData($weatherData);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Leon\Weather\Weather\Api\Data\WeatherInterface
     */
    public function setCreatedAt($createdAt);
}

