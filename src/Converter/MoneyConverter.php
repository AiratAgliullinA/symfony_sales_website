<?php

namespace App\Converter;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

/**
 * Money converter class
 */
class MoneyConverter
{
    const MAIN_CURRENCY_ISO = 'USD';
    const MAIN_LOCALE = 'en_US';

    /**
     * Create money object
     *
     * @param int $num
     * @param string $currency
     *
     * @return Money
     */
    public static function createMoneyObject(int $num, string $currency): Money
    {
        return new Money($num, new Currency($currency));
    }

    /**
     * Return formatted money to display
     *
     * @param Money $money
     *
     * @return string
     */
    public static function getFormattedMoney(Money $money): string
    {
        // Because amount has integer type, we are recreate money object
        $money = static::createMoneyObject($money->getAmount(), $money->getCurrency());
        $currencies = new ISOCurrencies();
        $numberFormatter = new NumberFormatter(self::MAIN_LOCALE, NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($money);
    }
}