<?php declare(strict_types=1);

namespace App\Calculator;

use App\Entity\Employee;
use App\SalaryRateCalculationRule\SalaryRateCalculationRuleInterface;

/**
 * The "SalaryRateCalculator" class
 */
class SalaryRateCalculator
{
    /**
     * Returns the salary rate
     *
     * @param Employee $employee
     * @param SalaryRateCalculationRuleInterface ...$rules
     *
     * @return \Money\Money
     */
    public function calculate(Employee $employee, SalaryRateCalculationRuleInterface ...$rules)
    {
        $rate = $employee->salaryRate();
        foreach ($rules as $rule) {
            if ($rule->isApplicable($employee)) {
                $rate = $rule->calculate($rate);
            }
        }

        return $rate;
    }
}