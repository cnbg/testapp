<?php

namespace App\Services;

use App\Contracts\IBinChecker;
use Exception;
use GuzzleHttp\Client as HttpClient;

class BinListCheckerService implements IBinChecker
{
    /**
     * check bin results from remote service
     *
     * @throws Exception
     */
    public function isInEu($bin): bool
    {
        $client = new HttpClient(['base_uri' => $_ENV['BIN_LIST_URL']]);

        $response = $client->request('GET', $bin);

        $content = $response->getBody()->getContents();

        if(empty($content)) {
            throw new Exception('Bin not found');
        }

        $jsonData = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        return $this->isCountryInEu($jsonData['country']['alpha2']);
    }

    /**
     * check code if it is in eu countries
     *
     * @param $code
     *
     * @return bool
     */
    private function isCountryInEu($code): bool
    {
        $codes = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK',];

        return in_array($code, $codes, true); /* strict checks also for data types */
    }
}
