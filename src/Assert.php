<?php declare(strict_types=1);

namespace App;

use \Webmozart\Assert\Assert as WebmozartAssert;

/**
 * The "Assert" class
 */
class Assert extends WebmozartAssert
{
    /**
     * The majority assert
     *
     * @param \DateTimeInterface $birthDate
     * @param int $majority
     * @param string $message
     */
    public static function majority(\DateTimeInterface $birthDate, int $majority = 18, string $message = '')
    {
        $now = new \DateTimeImmutable();
        $interval = $now->diff($birthDate);
        if ($interval->invert === 0 || $interval->y < $majority) {
            static::reportInvalidArgument(
                \sprintf(
                    $message ?: 'The interval between %s and %s in years must greater than or equals %d',
                    static::valueToString($now),
                    static::valueToString($birthDate),
                    $majority
                )
            );
        }
    }
}