<?php
declare(strict_types=1);

namespace Leon\Weather\Service\Weather;

use Leon\Weather\Api\WeatherApiServiceInterface;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use GuzzleHttp\Exception\GuzzleException;
use Magento\Framework\Webapi\Rest\Request;
use Leon\Weather\Logger\Logger;


class WeatherApiService implements WeatherApiServiceInterface
{
    /**
     * API request URL
     */
    const API_REQUEST_URI = 'https://api.openweathermap.org/';

    /**
     * API request endpoint
     */
    const API_REQUEST_ENDPOINT = 'data/2.5/weather?q=lublin,pl&units=metric&APPID=2b5c54fe82c868ba5206f8492b3e61c8';

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(
        ClientFactory   $clientFactory,
        ResponseFactory $responseFactory,
        Logger          $logger
    )
    {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->logger = $logger;
    }

    /**
     * @return string
     */
    public function getWeather(): string
    {
        $result = '';
        try {
            $response = $this->doRequest(self::API_REQUEST_URI . self::API_REQUEST_ENDPOINT, [], Request::HTTP_METHOD_GET);
            $status = $response->getStatusCode();
            if ($status == 200) {
                $result = $response->getBody()->getContents();
                $this->logger->debug('API response: ' . $result);
            }
        } catch (\Exception $e) {
            $this->logger->error('Error while receiving weather request: ' . $e->getMessage());
        } finally {
            /** @var string $result */
            return $result;
        }
    }

    private function doRequest($uriEndpoint, $params = [], $requestMethod = Request::HTTP_METHOD_GET)
    {
        try {
            /** @var Client $client */
            $client = $this->clientFactory->create(['config' => [
                'base_uri' => self::API_REQUEST_URI
            ]]);
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $e) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $e->getCode(),
                'reason' => $e->getMessage()
            ]);
            $this->logger->error('Error while receiving weather request: ' . $e->getMessage());
        }
        return $response;
    }
}
