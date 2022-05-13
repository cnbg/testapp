<?php

namespace Tests;

use App\Services\FirstService;
use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{
    public function test_first_service_invoke_123()
    {
        $obj = new FirstService;

        $this->assertEquals('123', $obj());
    }
}
