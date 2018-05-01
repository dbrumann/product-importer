<?php declare(strict_types = 1);

namespace App\Entity;

use App\Value\Price;
use App\Value\TaxRate;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity()
 */
final class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\Column()
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="price")
     */
    private $price;

    /**
     * @ORM\Column(type="taxrate")
     */
    private $taxRate;

    public function __construct(string $name, string $description, Price $price, TaxRate $taxRate)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->taxRate = $taxRate;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getTaxRate(): TaxRate
    {
        return $this->taxRate;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
