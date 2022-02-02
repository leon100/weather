<?php

namespace Leon\Weather\Controller\Weather;

use Leon\Weather\Model\ResourceModel\Weather\CollectionFactory as WeatherCollectionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Leon\Weather\Logger\Logger;
use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Response;

class Index extends Action
{
    /**
     * @var WeatherCollectionFactory
     */
    private $weatherCollectionFactory;
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(
        Context                  $context,
        WeatherCollectionFactory $weatherCollectionFactory,
        Logger                   $logger
    )
    {
        parent::__construct($context);
        $this->weatherCollectionFactory = $weatherCollectionFactory;
        $this->logger = $logger;
    }

    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        try {
            $weather = $this->weatherCollectionFactory->create()->getLastItem()->getWeatherData();
            $resultJson->setHttpResponseCode(Response::HTTP_OK);
            $resultJson->setData($weather);
            return $resultJson;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $resultJson->setHttpResponseCode(Exception::HTTP_BAD_REQUEST);
            return $resultJson->setData([]);
        }
    }
}
