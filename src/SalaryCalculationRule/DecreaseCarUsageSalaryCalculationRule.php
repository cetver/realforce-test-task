<?php declare(strict_types=1);

namespace App\SalaryCalculationRule;

use App\Entity\Employee;
use Money\Money;

/**
 * The "DecreaseCarUsageSalaryCalculationRule" class
 */
class DecreaseCarUsageSalaryCalculationRule implements SalaryCalculationRuleInterface
{
    /**
     * @inheritDoc
     */
    public function isApplicable(Employee $employee): bool
    {
        return $employee->hasCompanyCar();
    }

    /**
     * @inheritDoc
     */
    public function calculate(Money $salaryRate): Money
    {
        $carUsageAmount = new Money(50000, $salaryRate->getCurrency());

        return $salaryRate->subtract($carUsageAmount);
    }
}