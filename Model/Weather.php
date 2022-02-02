<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Leon\Weather\Model;

use Leon\Weather\Api\Data\WeatherInterface;
use Magento\Framework\Model\AbstractModel;

class Weather extends AbstractModel implements WeatherInterface
{

    public function _construct()
    {
        $this->_init(\Leon\Weather\Model\ResourceModel\Weather::class);
    }

    public function getWeatherId()
    {
        return $this->getData(self::WEATHER_ID);
    }

    public function setWeatherId($weatherId)
    {
        return $this->setData(self::WEATHER_ID, $weatherId);
    }

    public function getWeatherData()
    {
        return $this->getData(self::WEATHER_DATA);
    }

    public function setWeatherData($weatherData)
    {
        return $this->setData(self::WEATHER_DATA, $weatherData);
    }

    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}

