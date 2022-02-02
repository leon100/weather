<?php

declare(strict_types=1);

namespace Leon\Weather\Setup\Patch\Data;

use Leon\Weather\Api\WeatherRepositoryInterface;
use Leon\Weather\Logger\Logger;
use Leon\Weather\Model\WeatherFactory;
use Leon\Weather\Service\Weather\WeatherApiService;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddWeatherRecord implements DataPatchInterface
{

    /**
     * @var WeatherApiService
     */
    private $weatherService;
    /**
     * @var WeatherRepositoryInterface
     */
    private $weatherRepository;
    /**
     * @var WeatherFactory
     */
    private $weatherFactory;
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(
        WeatherApiService          $weatherService,
        WeatherFactory             $weatherFactory,
        WeatherRepositoryInterface $weatherRepository,
        Logger                     $logger
    )
    {
        $this->weatherService = $weatherService;
        $this->weatherFactory = $weatherFactory;
        $this->weatherRepository = $weatherRepository;
        $this->logger = $logger;

    }

    public function apply()
    {
        try {
            $response = $this->weatherService->getWeather();
            if ($response) {
                $weather = $this->weatherFactory->create();
                $weather->setWeatherData($response);
                $this->weatherRepository->save($weather);
            }
        } catch (\Exception $e) {
            $this->logger->error('Error while saving weather in patch: ' . $e->getMessage());
        }
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }
}
