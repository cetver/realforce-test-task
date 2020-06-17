<?php declare(strict_types=1);

namespace App\SalaryRateCalculationRule;

use App\Entity\Employee;
use Money\Money;

/**
 * The "IncreaseOlderThanFiftySalaryRateCalculationRule" class
 */
class IncreaseOlderThanFiftySalaryRateCalculationRule implements SalaryRateCalculationRuleInterface
{
    /**
     * @inheritDoc
     */
    public function isApplicable(Employee $employee): bool
    {
        return $employee->age() > 50;
    }

    /**
     * @inheritDoc
     */
    public function calculate(Money $salaryRate): Money
    {
        $amount = $salaryRate->multiply(0.07);

        return $salaryRate->add($amount);
    }
}