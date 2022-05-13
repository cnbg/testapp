<?php
require_once __DIR__ . '/../server.php';

use App\Services\ApiLayerExchangeRateReaderService;
use App\Services\BinListCheckerService;
use App\Services\CommissionCalculatorService;
use App\Services\LocalFileReaderService;

/* TODO: configure DI */
$transactionReader = new LocalFileReaderService();
$binChecker = new BinListCheckerService();
$exchangeRateReader = new ApiLayerExchangeRateReaderService();
//$exchangeReader = new \App\Services\SomeSiteExchangeReader();

$commissionCalculator = new CommissionCalculatorService($transactionReader, $binChecker, $exchangeRateReader);

try {
    $commissions = $commissionCalculator->calculate();
    echo '<table border="1"><tr><td>Bin</td><td>Commission</td></tr>';
    foreach($commissions as $bin => $commission) {
        echo "<tr><td width='100'>{$bin}</td><td width='100'>{$commission}</td></tr>";
    }
    echo '</table>';

} catch(Exception $e) {
    echo $e->getMessage();
}
