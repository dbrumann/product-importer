<?php declare(strict_types = 1);

namespace App\Tests\Value;

use App\Value\Price;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testItCanBeCreatedFromCents()
    {
        $money = Price::fromCents(999);

        $this->assertSame(999, $money->get());
        $this->assertSame('9.99', (string) $money);
    }

    public function testItCanBeCreatedFromEuros()
    {
        $money = Price::fromEuros(36.50);

        $this->assertSame(3650, $money->get());
        $this->assertSame('36.50', (string) $money);
    }
}
