<?php declare(strict_types=1);

namespace App\Tax;

/**
 * The "TaxInterface" class
 */
interface TaxInterface
{
    /**
     * Returns tax percentage
     *
     * @return int
     */
    public function percentage(): int;
}