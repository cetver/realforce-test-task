<?php declare(strict_types=1);

namespace App\Calculator;

use App\Entity\Employee;
use App\Tax\TaxInterface;
use App\TaxCalculationRule\TaxCalculationRuleInterface;
use App\ValueObject\Tax;

/**
 * The "TaxCalculator" class
 */
class TaxCalculator
{
    /**
     * Returns the tax based on rules
     *
     * @param Employee $employee
     * @param TaxInterface $initialTax
     * @param TaxCalculationRuleInterface ...$rules
     *
     * @return Tax
     */
    public function calculate(Employee $employee, TaxInterface $initialTax, TaxCalculationRuleInterface ...$rules)
    {
        $tax = new Tax($initialTax->percentage());
        foreach ($rules as $rule) {
            if ($rule->isApplicable($employee)) {
                $tax = $rule->calculate($tax);
            }
        }

        return $tax;
    }
}