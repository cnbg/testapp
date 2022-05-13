<?php

namespace Tests;

use App\Services\ApiLayerExchangeRateReaderService;
use App\Services\BinListCheckerService;
use App\Services\CommissionCalculatorService;
use App\Services\LocalFileReaderService;
use PHPUnit\Framework\TestCase;

class CommissionCalculatorServiceTest extends TestCase
{

    public function test_get_fixed_amount()
    {
        $transaction = ["bin" => "45717360", "amount" => "100.00", "currency" => "EUR"];

        $checker = $this->getMockBuilder(BinListCheckerService::class)->getMock();

        $checker->method('isInEu')
                ->with('45717360')
                ->willReturn(true);

        $reader = $this->getMockBuilder(LocalFileReaderService::class)->getMock();

        $reader->method('getTransactions')
               ->willReturn([$transaction]);

        $exchange = $this->getMockBuilder(ApiLayerExchangeRateReaderService::class)->getMock();

        $exchange->method('getRate')
               ->with('EUR')
               ->willReturn(1.00);

        $comissionCalculator = new CommissionCalculatorService($reader, $checker, $exchange);

        $this->assertEquals('1.00', $comissionCalculator->getFixedAmount($transaction));
    }
}
