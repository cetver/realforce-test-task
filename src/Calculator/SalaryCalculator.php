<?php declare(strict_types=1);

namespace App\Calculator;

use App\Entity\Employee;
use App\SalaryCalculationRule\SalaryCalculationRuleInterface;
use App\ValueObject\Tax;
use Money\Money;

/**
 * The "SalaryCalculator" class
 */
class SalaryCalculator
{
    /**
     * Returns the salary based on the tax and rules
     *
     * @param Employee $employee
     * @param Money $salaryRate
     * @param Tax $tax
     * @param SalaryCalculationRuleInterface ...$rules
     *
     * @return Money
     */
    public function calculate(Employee $employee, Money $salaryRate, Tax $tax, SalaryCalculationRuleInterface ...$rules)
    {
        $salary = $salaryRate;
        foreach ($rules as $rule) {
            if ($rule->isApplicable($employee)) {
                $salary = $rule->calculate($salary);
            }
        }

        if (!$tax->isZero()) {
            $taxAmount = ((int)$salary->getAmount() * $tax->getValue()) / 100;
            $taxMoney = new Money($taxAmount, $salary->getCurrency());
            $salary = $salary->subtract($taxMoney);
        }

        return $salary;
    }
}