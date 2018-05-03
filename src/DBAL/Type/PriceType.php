<?php declare(strict_types = 1);

namespace App\DBAL\Type;

use App\Value\Price;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class PriceType extends Type
{
    public function getName(): string
    {
        return 'price';
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return $value;
        }

        if ($value instanceof Price) {
            return $value->get();
        }

        throw new ConversionException('Money field requires value to be of type App\\Value\\Money.');
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return $value;
        }

        return Price::fromCents((int) $value);
    }
}
