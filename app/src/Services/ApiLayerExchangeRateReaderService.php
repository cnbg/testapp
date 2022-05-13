<?php

namespace App\Services;

use App\Contracts\IExchangeRateReader;
use Exception;
use GuzzleHttp\Client as HttpClient;

class ApiLayerExchangeRateReaderService implements IExchangeRateReader
{
    private string $domain;
    private string $apiKey;
    private string $baseCurrency;

    public function __construct()
    {
        $this->domain = $_ENV['API_LAYER_URL'];
        $this->apiKey = $_ENV['API_LAYER_KEY'];
        $this->baseCurrency = $_ENV['API_LAYER_CURRENCY'];
    }

    /**
     * @throws Exception
     */
    public function getRate($currency)
    {
        $client = new HttpClient(['base_uri' => $this->domain]);

        $response = $client->request('GET', '', [
            'query' => [
                'base'   => $this->baseCurrency,
                'apikey' => $this->apiKey,
            ],
        ]);

        $content = $response->getBody()->getContents();

        if(empty($content)) {
            throw new Exception('Rate not found');
        }

        $jsonData = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        return $jsonData['rates'][$currency] ?? 0;
    }
}
