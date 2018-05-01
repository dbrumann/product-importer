<?php declare(strict_types = 1);

namespace App\Value;

use function in_array;
use InvalidArgumentException;
use function number_format;

final class TaxRate
{
    private $taxRate;

    public function __construct(int $taxRate)
    {
        if (!in_array($taxRate, [700, 1900], true)) {
            throw new InvalidArgumentException('Tax rate must either be 700 (reduced) or 1900 (default).');
        }

        $this->taxRate = $taxRate;
    }

    public static function defaultTaxRate(): self
    {
        return new self(1900);
    }

    public static function reducedTaxRate(): self
    {
        return new self(700);
    }

    public function get(): int
    {
        return $this->taxRate;
    }

    public function __toString(): string
    {
        return number_format($this->taxRate / 100, 2);
    }
}
