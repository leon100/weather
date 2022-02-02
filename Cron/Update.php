<?php

namespace Leon\Weather\Cron;

use Leon\Weather\Api\WeatherRepositoryInterface;
use Leon\Weather\Logger\Logger;
use Leon\Weather\Model\WeatherFactory;
use Leon\Weather\Service\Weather\WeatherApiService;

class Update
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

    public function execute()
    {
        try {
            $response = $this->weatherService->getWeather();
            if ($response) {
                $weather = $this->weatherFactory->create();
                $weather->setWeatherData($response);
                $this->weatherRepository->save($weather);
            }
        } catch (\Exception $e) {
            $this->logger->error('Error while saving weather in cron: ' . $e->getMessage());
        }
    }
}
