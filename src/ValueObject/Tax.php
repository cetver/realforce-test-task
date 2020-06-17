<?php declare(strict_types=1);

namespace App\ValueObject;

use App\Assert;

/**
 * The "Tax" class
 */
class Tax
{
    /**
     * @var int
     */
    private $value;

    public function __construct(int $value)
    {
        Assert::range($value, 0, 100);
        $this->value = $value;
    }

    /**
     * Returns the value represented by this object
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Whether the value represented by this object is zero
     *
     * @return bool
     */
    public function isZero(): bool
    {
        return $this->value === 0;
    }
}