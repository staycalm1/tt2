<?php

namespace StayCalm1\Tt2\Currencies;

class Source
{
    /**
     * @param string $from Из какой валюты.
     * @param string $to В какую валюту.
     * @return string Курс обмена одной валюты на другую
     * @throws \StayCalm1\Tt2\Currencies\UnrecoverableException В случае, если пара не найдена.
     */
    public function getPairRate($from, $to)
    {
        switch ($from . $to) {
            case Currency::RUB . Currency::USD:
                return '62.8061801';
            case Currency::USD . Currency::RUB:
                return '0.015922';
            default:
                throw new UnrecoverableException();
        }
    }
}