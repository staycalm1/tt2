<?php

use StayCalm1\Tt2\Currencies\Converter;
use StayCalm1\Tt2\Currencies\Source;
use StayCalm1\Tt2\Currencies\Currency;
use StayCalm1\Tt2\Currencies\UnrecoverableException;

class CurrenciesTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    public function testCurrencyExchange()
    {
        $converter = new Converter(new Source());

        // Меняем рубли на доллары
        $result = $converter->convert(Currency::RUB, Currency::USD, 10000);
        $this->assertEquals('159.22', $result);

        // Меняем доллары на рубли
        $result = $converter->convert(Currency::USD, Currency::RUB, 52);
        $this->assertEquals('3265.92', $result);

        // Меняем фантики на рубли
        $this->expectException(UnrecoverableException::class);
        $converter->convert(Currency::FUN, Currency::RUB, 52);
    }
}