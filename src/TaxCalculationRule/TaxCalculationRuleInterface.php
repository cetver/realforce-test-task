<?php declare(strict_types=1);

namespace App\TaxCalculationRule;

use App\Entity\Employee;
use App\ValueObject\Tax;

/**
 * The "TaxCalculationRuleInterface" class
 */
interface TaxCalculationRuleInterface
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
     * Returns the calculated tax
     *
     * @param Tax $tax
     *
     * @return Tax
     */
    public function calculate(Tax $tax): Tax;
}