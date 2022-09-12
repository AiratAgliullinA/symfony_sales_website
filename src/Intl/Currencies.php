<?php

namespace App\Intl;

use Symfony\Component\Intl\Currencies as CurrenciesComponent;

/**
 * Currencies
 */
class Currencies
{
    const MAIN_CURRENCY_ISO = 'USD';

    /**
     * Return symbol
     *
     * @param string $currencyIso
     *
     * @return string
     */
    public static function getSymbol(string $currencyIso): string
    {
        return CurrenciesComponent::getSymbol($currencyIso);
    }
}