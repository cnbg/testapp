<?php

namespace App\Services;

use App\Contracts\ITransactionReader;
use Exception;

class SomeSiteReaderService implements ITransactionReader
{
    /**
     * @throws Exception
     */
    public function getTransactions()
    {
        throw new Exception("Not implemented");
    }
}
