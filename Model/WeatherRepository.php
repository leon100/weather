<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Leon\Weather\Model;

use Leon\Weather\Api\Data\WeatherInterface;
use Leon\Weather\Api\Data\WeatherInterfaceFactory;
use Leon\Weather\Api\Data\WeatherSearchResultsInterfaceFactory;
use Leon\Weather\Api\WeatherRepositoryInterface;
use Leon\Weather\Model\ResourceModel\Weather as ResourceWeather;
use Leon\Weather\Model\ResourceModel\Weather\CollectionFactory as WeatherCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class WeatherRepository implements WeatherRepositoryInterface
{

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ResourceWeather
     */
    protected $resource;

    /**
     * @var Weather
     */
    protected $searchResultsFactory;

    /**
     * @var WeatherInterfaceFactory
     */
    protected $weatherFactory;

    /**
     * @var WeatherCollectionFactory
     */
    protected $weatherCollectionFactory;


    /**
     * @param ResourceWeather $resource
     * @param WeatherInterfaceFactory $weatherFactory
     * @param WeatherCollectionFactory $weatherCollectionFactory
     * @param WeatherSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceWeather $resource,
        WeatherInterfaceFactory $weatherFactory,
        WeatherCollectionFactory $weatherCollectionFactory,
        WeatherSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->weatherFactory = $weatherFactory;
        $this->weatherCollectionFactory = $weatherCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function save(WeatherInterface $weather)
    {
        try {
            $this->resource->save($weather);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the weather: %1',
                $exception->getMessage()
            ));
        }
        return $weather;
    }

    public function get($weatherId)
    {
        $weather = $this->weatherFactory->create();
        $this->resource->load($weather, $weatherId);
        if (!$weather->getId()) {
            throw new NoSuchEntityException(__('Weather with id "%1" does not exist.', $weatherId));
        }
        return $weather;
    }

    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->weatherCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    public function delete(WeatherInterface $weather)
    {
        try {
            $weatherModel = $this->weatherFactory->create();
            $this->resource->load($weatherModel, $weather->getWeatherId());
            $this->resource->delete($weatherModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Weather: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($weatherId)
    {
        return $this->delete($this->get($weatherId));
    }
}

