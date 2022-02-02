<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Leon\Weather\Api\Data;

interface WeatherSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Weather list.
     * @return \Leon\Weather\Api\Data\WeatherInterface[]
     */
    public function getItems();

    /**
     * Set weather_data list.
     * @param \Leon\Weather\Api\Data\WeatherInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

