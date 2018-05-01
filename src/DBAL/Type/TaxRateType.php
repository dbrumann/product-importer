<?php declare(strict_types = 1);

namespace App\DBAL\Type;

use App\Value\TaxRate;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

final class TaxRateType extends Type
{
    public function getName(): string
    {
        return 'taxrate';
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

        if ($value instanceof TaxRate) {
            return $value->get();
        }

        throw new ConversionException('Taxrate field requires value to be of type App\\Value\\TaxRate.');
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return $value;
        }

        try {
            return new TaxRate($value);
        } catch (InvalidArgumentException $exception) {
            throw new ConversionException(
                sprintf('Could not create tax rate from value "%d".', $value),
                0,
                $exception
            );
        }
    }
}
