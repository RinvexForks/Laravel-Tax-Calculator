<?php

namespace BrianFaust\TaxCalculator;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as MoneyPhp;
use NumberFormatter;

class Money
{
    /**
     * @var \Money\Money
     */
    private $money;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $language;

    /**
     * @param float  $amount
     * @param string $currency
     * @param string $language
     */
    public function __construct($amount, string $currency, string $language)
    {
        $this->money = new MoneyPhp($amount, new Currency($currency));
        $this->currency = $currency;
        $this->language = $language;
    }

    /**
     * @return float
     */
    public function decimal() : float
    {
        return (new DecimalMoneyFormatter(new ISOCurrencies()))->format($this->money);
    }

    /**
     * @return string
     */
    public function format() : string
    {
        $numberFormatter = new NumberFormatter($this->language, NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        return $moneyFormatter->format($this->money);
    }

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        return call_user_func_array([$this->money, $method], $arguments);
    }
}