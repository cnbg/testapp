<?php

namespace App\Services;

use PHPUnit\Framework\TestCase;

class BinListCheckerServiceTest extends TestCase
{

    public function test_is_in_eu()
    {
        $checker = new BinListCheckerService();

        $this->assertTrue($checker->isInEu('45717360'));
        $this->assertTrue($checker->isInEu('516793'));
        $this->assertFalse($checker->isInEu('45417360'));
        $this->assertFalse($checker->isInEu('41417360'));
        $this->assertFalse($checker->isInEu('4745030'));
    }
}
