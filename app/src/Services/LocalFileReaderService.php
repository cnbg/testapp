<?php

namespace App\Services;

use App\Contracts\ITransactionReader;
use Exception;

class LocalFileReaderService implements ITransactionReader
{
    private string $file;

    public function __construct() {
        $this->file = $_ENV['TRANSACTION_FILE'];
    }

    /**
     * reads exchange information from file
     *
     * @return array
     */
    public function getTransactions(): array
    {
        $rows = explode("\n", file_get_contents($this->file));

        foreach($rows as $key => $row) {
            try {
                $transactions[] = json_decode($row, true, 512, JSON_THROW_ON_ERROR);
            } catch(Exception $e) {
                /* TODO: log error for analysis */
                continue;
            }
        }

        return $transactions ?? [];
    }
}
