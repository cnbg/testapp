<?php

namespace Tests;

use App\Services\LocalFileReaderService;
use PHPUnit\Framework\TestCase;

class LocalFileReaderServiceTest extends TestCase
{
    public function test_get_transactions()
    {
        $reader = new LocalFileReaderService();

        $transactions = $reader->getTransactions();

        foreach($transactions as $transaction) {
            $this->assertArrayHasKey("bin", $transaction);
            $this->assertArrayHasKey("amount", $transaction);
            $this->assertArrayHasKey("currency", $transaction);
        }
    }
}
