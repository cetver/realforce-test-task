<?php declare(strict_types=1);

namespace App\SalaryCalculationRule;

use App\Entity\Employee;
use Money\Money;

/**
 * The "SalaryCalculationRuleInterface" interface
 */
interface SalaryCalculationRuleInterface
{
    /**
     * Whether to apply the rule
     *
     * @param Employee $employee
     *
     * @return bool
     */
    public function isApplicable(Employee $employee): bool;

    /**
     * Returns the calculated salary
     *
     * @param Money $salaryRate
     *
     * @return Money
     */
    public function calculate(Money $salaryRate): Money;
}