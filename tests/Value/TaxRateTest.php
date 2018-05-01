<?php declare(strict_types = 1);

namespace App\Tests\Value;

use App\Value\TaxRate;
use PHPUnit\Framework\TestCase;

class TaxRateTest extends TestCase
{
    public function testItCanCreateDefaultTaxRate()
    {
        $taxRate = TaxRate::defaultTaxRate();

        $this->assertSame(1900, $taxRate->get());
        $this->assertSame('19.00', (string) $taxRate);
    }

    public function testItCanCreateReducedTaxRate()
    {
        $taxRate = TaxRate::reducedTaxRate();

        $this->assertSame(700, $taxRate->get());
        $this->assertSame('7.00', (string) $taxRate);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testItThrowsExceptionWhenInvalidTaxRateIsProvided()
    {
        new TaxRate(350);
    }
}
