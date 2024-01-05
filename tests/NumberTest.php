<?php

use Bjm0001\Utils\Number;
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    public function testScToNum()
    {
        $this->assertEquals('3500000',Number::scToNum('3.5e6'));
        $this->assertEquals('0.000045',Number::scToNum('4.5e-5'));
        $this->assertEquals('123430.001',Number::scToNum('1.23430001e5'));
    }


    public function testNumToSc()
    {
        $this->assertEquals('3.5e6',Number::numToSc('3500000'));
        $this->assertEquals('4.5e-5',Number::numToSc('0.000045'));
        $this->assertEquals('1.23430001e5',Number::numToSc('123430.001'));
        $this->assertEquals('1.2343000000000001e5',Number::numToSc('123430.00000000001'));
    }
}