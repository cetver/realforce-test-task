<?php declare(strict_types=1);

namespace App\SalaryRateCalculationRule;

use App\Entity\Employee;
use Money\Money;

/**
 * The "SalaryRateCalculationRuleInterface" interface
 */
interface SalaryRateCalculationRuleInterface 
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
     * Returns the calculated salary rate
     *
     * @param Money $salaryRate
     *
     * @return Money
     */
    public function calculate(Money $salaryRate): Money;
}