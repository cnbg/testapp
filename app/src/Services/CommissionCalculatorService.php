<?php

namespace App\Services;

use App\Contracts\IBinChecker;
use App\Contracts\IExchangeRateReader;
use App\Contracts\ITransactionReader;

/* TODO: service can be refactored later */
class CommissionCalculatorService
{
    private ITransactionReader $transactionReader;
    private IBinChecker $binChecker;
    private IExchangeRateReader $exchangeRateReader;

    private float $euCommission;
    private float $nonEuCommission;

    public function __construct(
        ITransactionReader $transactionReader,
        IBinChecker $binChecker,
        IExchangeRateReader $exchangeRateReader
    )
    {
        $this->transactionReader = $transactionReader;
        $this->binChecker = $binChecker;
        $this->exchangeRateReader = $exchangeRateReader;

        $this->euCommission = $_ENV['EU_COMMISSION'];
        $this->nonEuCommission = $_ENV['NON_EU_COMMISSION'];
    }

    public function calculate()
    {
        $transactions = $this->transactionReader->getTransactions();

        /* TODO: implement queue */
        foreach($transactions as $transaction) {
            $bin = $transaction['bin'];

            $commissions[$bin] = $this->getFixedAmount($transaction);
        }

        return $commissions ?? [];
    }

    /**
     * @param mixed $transaction
     *
     */
    public function getFixedAmount(mixed $transaction): string
    {
        $bin = $transaction['bin'];

        $countryCommission = $this->binChecker->isInEu($bin) ? $this->euCommission : $this->nonEuCommission;

        $currency = $transaction['currency'];

        /* checking first for EUR currency eliminates extra requests to exchange rate service */
        if($currency === 'EUR') {
            $fixedAmount = $transaction['amount'];
        } else {
            $rate = $this->exchangeRateReader->getRate($currency);

            $fixedAmount = $rate ? ($transaction['amount'] / $rate) : $transaction['amount'];
        }

        /* number format used instead of round to force decimals */
        return number_format($fixedAmount * $countryCommission, 2);
    }
}
