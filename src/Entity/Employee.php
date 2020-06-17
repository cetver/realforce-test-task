<?php declare(strict_types=1);

namespace App\Entity;

use App\Assert;
use Money\Money;

/**
 * The "Employee" class
 */
class Employee
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var \DateTimeInterface
     */
    private $birthDate;
    /**
     * @var Money
     */
    private $salaryRate;
    /**
     * @var int
     */
    private $kidsNumber;
    /**
     * @var bool
     */
    private $hasCompanyCar;

    public function __construct(
        string $name,
        \DateTimeInterface $birthDate,
        Money $salaryRate,
        int $kidsNumber = 0,
        bool $hasCompanyCar = false
    )
    {
        Assert::lengthBetween($name, '2', '255');
        Assert::majority($birthDate);
        Assert::range($kidsNumber, 0, 100);

        $this->name = $name;
        $this->birthDate = $birthDate;
        $this->salaryRate = $salaryRate;
        $this->kidsNumber = $kidsNumber;
        $this->hasCompanyCar = $hasCompanyCar;
    }

    /**
     * @inheritDoc
     */
    public function salaryRate(): Money
    {
        return $this->salaryRate;
    }

    /**
     * Returns age
     *
     * @return int
     */
    public function age(): int
    {
        $now = new \DateTimeImmutable();
        $interval = $this->birthDate->diff($now);

        return $interval->y;
    }

    /**
     * Returns the capitalized name
     *
     * @return string
     */
    public function name(): string
    {
        $firstCharacter = mb_strtoupper(mb_substr($this->name, 0, 1));
        $otherCharacters = mb_substr($this->name, 1);

        return $firstCharacter . $otherCharacters;
    }

    /**
     * @return \DateTimeInterface
     * @see $birthDate
     */
    public function getBirthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    /**
     * @return int
     * @see $kidsNumber
     */
    public function getKidsNumber(): int
    {
        return $this->kidsNumber;
    }

    /**
     * @return bool
     * @see $hasCompanyCar
     */
    public function hasCompanyCar(): bool
    {
        return $this->hasCompanyCar;
    }
}