<?php

namespace App\Tax;

/**
 * The "UsaTax" class
 */
class UsaTax implements TaxInterface
{
    /**
     * @inheritDoc
     */
    public function percentage(): int
    {
        return 20;
    }
}