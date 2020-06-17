<?php

require_once 'vendor/autoload.php';

use App\Entity\Employee;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;

//$fiveEur = Money::EUR(500);
//var_dump($fiveEur);



$usd = new Currency('USD');
$alice = new Employee('Alice', new \DateTimeImmutable('-26 years'), new Money(600000, $usd), 2);
$bob = new Employee('Bob', new \DateTimeImmutable('-52 years'), new Money(400000, $usd), 0, true);
$charlie = new Employee('Charlie', new \DateTimeImmutable('-36 years'), new Money(500000, $usd), 3, true);
$employees = [
    $alice,
    $bob,
    $charlie
];



foreach ($employees as $employee) {
    var_dump($employee->name());

    $salaryRateRules = [
        new \App\SalaryRateCalculationRule\IncreaseOlderThanFiftySalaryRateCalculationRule()
    ];
    $salaryRateCalculator = new \App\Calculator\SalaryRateCalculator();
    $salaryRate = $salaryRateCalculator->calculate($employee, ...$salaryRateRules);

    $taxCalculator = new \App\Calculator\TaxCalculator();
    $taxCalculatorRules = [
        new \App\TaxCalculationRule\DecreaseMoreThanTwoKidsTaxCalculationRule()
    ];
    $tax = $taxCalculator->calculate($employee, new \App\Tax\UsaTax(), ...$taxCalculatorRules);


    $salaryCalculator = new \App\Calculator\SalaryCalculator();
    $salaryCalculatorRules = [
        new \App\SalaryCalculationRule\DecreaseCarUsageSalaryCalculationRule(),
    ];
    $salary = $salaryCalculator->calculate($employee, $salaryRate, $tax, ...$salaryCalculatorRules);
    var_dump($salary->getAmount());
}


//$fiver = new Money(500, new Currency('USD'));
//var_dump($fiver);
//
//
//$currencies = new ISOCurrencies();
//foreach ($currencies as $currency) {
//    var_dump($currency->getCode());
//}