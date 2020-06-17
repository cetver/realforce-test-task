<?php declare(strict_types=1);

namespace App\TaxCalculationRule;

use App\Entity\Employee;
use App\ValueObject\Tax;

/**
 * The "DescreaseMoreThanTwoKidsTaxCalculationRule" class
 */
class DecreaseMoreThanTwoKidsTaxCalculationRule implements TaxCalculationRuleInterface
{
    /**
     * @inheritDoc
     */
    public function isApplicable(Employee $employee): bool
    {
        return $employee->getKidsNumber() > 2;
    }

    /**
     * @inheritDoc
     */
    public function calculate(Tax $tax): Tax
    {
        $value = $tax->getValue() - 2;

        return new Tax($value);
    }
}