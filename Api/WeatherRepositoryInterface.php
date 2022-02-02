<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Leon\Weather\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface WeatherRepositoryInterface
{

    /**
     * Save Weather
     * @param \Leon\Weather\Api\Data\WeatherInterface $weather
     * @return \Leon\Weather\Api\Data\WeatherInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Leon\Weather\Api\Data\WeatherInterface $weather
    );

    /**
     * Retrieve Weather
     * @param string $weatherId
     * @return \Leon\Weather\Api\Data\WeatherInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($weatherId);

    /**
     * Retrieve Weather matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Leon\Weather\Api\Data\WeatherSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Weather
     * @param \Leon\Weather\Api\Data\WeatherInterface $weather
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Leon\Weather\Api\Data\WeatherInterface $weather
    );

    /**
     * Delete Weather by ID
     * @param string $weatherId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($weatherId);
}

