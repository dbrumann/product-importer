<?php declare(strict_types = 1);

namespace App\Value;

use function number_format;

final class Price
{
    private $centValue;

    private function __construct(int $centValue)
    {
        $this->centValue = $centValue;
    }

    public static function fromCents(int $centValue): self
    {
        return new self($centValue);
    }

    public static function fromEuros(float $euroValue): self
    {
        $centValue = (int) ($euroValue * 100);

        return new self($centValue);
    }

    public function get(): int
    {
        return $this->centValue;
    }

    public function __toString(): string
    {
        return number_format($this->centValue / 100, 2);
    }
}
