<?php declare(strict_types=1);

namespace Test\Calculator;

use App\Calculator\SalaryCalculator;
use App\Calculator\SalaryRateCalculator;
use App\Calculator\TaxCalculator;
use App\Entity\Employee;
use App\SalaryCalculationRule\DecreaseCarUsageSalaryCalculationRule;
use App\SalaryRateCalculationRule\IncreaseOlderThanFiftySalaryRateCalculationRule;
use App\Tax\UsaTax;
use App\TaxCalculationRule\DecreaseMoreThanTwoKidsTaxCalculationRule;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class SalaryCalculatorTest extends TestCase
{
    /**
     * @see testCalculate
     */
    public function dataProviderCalculate()
    {
        yield [
            'actual' => [
                'employee' => [
                    'name' => 'Alice',
                    'birthDate' => new \DateTimeImmutable('-26 years'),
                    'salaryRate' => new Money(600000, new Currency('USD')),
                    'kidsNumber' => 0,
                    'hasCompanyCar' => false,
                ],
                'tax' => new UsaTax(),
                'salaryRateRules' => [
                    new IncreaseOlderThanFiftySalaryRateCalculationRule(),
                ],
                'taxCalculatorRules' => [
                    new DecreaseMoreThanTwoKidsTaxCalculationRule(),
                ],
                'salaryCalculatorRules' => [
                    new DecreaseCarUsageSalaryCalculationRule(),
                ],
            ],
            'expected' => [
                'instance' => Money::class,
                'amount' => '480000',
                'currency' => 'USD',
            ],
            'message' => 'Alice is 26 years old, she has 2 kids and her salary is $6000',
        ];

        yield [
            'actual' => [
                'employee' => [
                    'name' => 'Bob',
                    'birthDate' => new \DateTimeImmutable('-52 years'),
                    'salaryRate' => new Money(400000, new Currency('USD')),
                    'kidsNumber' => 0,
                    'hasCompanyCar' => true,
                ],
                'tax' => new UsaTax(),
                'salaryRateRules' => [
                    new IncreaseOlderThanFiftySalaryRateCalculationRule(),
                ],
                'taxCalculatorRules' => [
                    new DecreaseMoreThanTwoKidsTaxCalculationRule(),
                ],
                'salaryCalculatorRules' => [
                    new DecreaseCarUsageSalaryCalculationRule(),
                ],
            ],
            'expected' => [
                'instance' => Money::class,
                'amount' => '302400',
                'currency' => 'USD',
            ],
            'message' => 'Bob is 52, he is using a company car and his salary is $4000',
        ];

        yield [
            'actual' => [
                'employee' => [
                    'name' => 'Charlie',
                    'birthDate' => new \DateTimeImmutable('-36 years'),
                    'salaryRate' => new Money(500000, new Currency('USD')),
                    'kidsNumber' => 3,
                    'hasCompanyCar' => true,
                ],
                'tax' => new UsaTax(),
                'salaryRateRules' => [
                    new IncreaseOlderThanFiftySalaryRateCalculationRule(),
                ],
                'taxCalculatorRules' => [
                    new DecreaseMoreThanTwoKidsTaxCalculationRule(),
                ],
                'salaryCalculatorRules' => [
                    new DecreaseCarUsageSalaryCalculationRule(),
                ],
            ],
            'expected' => [
                'instance' => Money::class,
                'amount' => '369000',
                'currency' => 'USD',
            ],
            'message' => 'Charlie is 36, he has 3 kids, company car and his salary is $5000',
        ];
    }

    /**
     * @dataProvider dataProviderCalculate
     * @covers       SalaryCalculator::calculate()
     *
     * @param array $actual
     * @param array $expected
     * @param string $message
     */
    public function testCalculate(array $actual, array $expected, string $message)
    {
        $employee = new Employee(
            $actual['employee']['name'],
            $actual['employee']['birthDate'],
            $actual['employee']['salaryRate'],
            $actual['employee']['kidsNumber'],
            $actual['employee']['hasCompanyCar']
        );
        $salaryRateCalculator = new SalaryRateCalculator();
        $salaryRate = $salaryRateCalculator->calculate($employee, ...$actual['salaryRateRules']);
        $taxCalculator = new TaxCalculator();
        $tax = $taxCalculator->calculate($employee, $actual['tax'], ...$actual['taxCalculatorRules']);
        $salaryCalculator = new SalaryCalculator();
        $salary = $salaryCalculator->calculate($employee, $salaryRate, $tax, ...$actual['salaryCalculatorRules']);

        $this->assertInstanceOf($expected['instance'], $salary, $message . ' (instance)');
        $this->assertSame($expected['amount'], $salary->getAmount(), $message . ' (amount)');
        $this->assertSame($expected['currency'], $salary->getCurrency()->getCode(), $message . ' (currency)');
    }
}
