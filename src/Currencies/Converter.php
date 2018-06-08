<?php

namespace StayCalm1\Tt2\Currencies;

/**
 * Используется для конвертации суммы из одной валюты в другую
 */
class Converter
{
    /**
     * @var \StayCalm1\Tt2\Currencies\Source
     */
    protected $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    /**
     * @param string $from Из какой валюты.
     * @param string $to В какую валюту.
     * @param mixed $amount Сумма в валюте $from.
     * @return string Сумма в валюте $to.
     * @throws \StayCalm1\Tt2\Currencies\UnrecoverableException
     */
    public function convert($from, $to, $amount)
    {
        $rate = $this->source->getPairRate($from, $to);

        // @todo В какую сторону округлять сумму?
        return bcdiv($amount, $rate, 2);
    }
}