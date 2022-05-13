<?php

namespace App\Contracts;

interface IExchangeRateReader
{
    public function getRate($currency);
}
