<?php

use StayCalm1\Tt2\Ads\Ad;
use StayCalm1\Tt2\Ads\AdsViewer;
use StayCalm1\Tt2\Ads\SourceDaemon;
use StayCalm1\Tt2\Ads\SourceDatabase;
use StayCalm1\Tt2\Currencies\Converter;
use StayCalm1\Tt2\Currencies\Currency;
use StayCalm1\Tt2\Currencies\Source;
use StayCalm1\Tt2\Logger;

class AdsTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testFetchAdsFromDatabase()
    {
        $source = new SourceDatabase();
        $ad = $source->fetch(14);
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(14, $ad->id);
        $this->assertEquals('AdName_FromMySQL', $ad->name);
        $this->assertEquals('AdText_FromMySQL', $ad->text);
        $this->assertEquals(10, $ad->price);
        $this->assertEquals(Currency::USD, $ad->currency);
    }

    public function testFetchAdsFromDaemon()
    {
        $source = new SourceDaemon();
        $ad = $source->fetch(15);
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(15, $ad->id);
        $this->assertEquals('AdName_FromDaemon', $ad->name);
        $this->assertEquals('AdText_FromDaemon', $ad->text);
        $this->assertEquals(11, $ad->price);
        $this->assertEquals(Currency::USD, $ad->currency);
    }

    public function testAdsViewer()
    {
        $converter = new Converter(new Source());

        // Проверяем, что вызывается logger

        // DATABASE
        $logger = $this->createMock(Logger::class);
        $logger
            ->expects($this->once())
            ->method('add')
            ->with($this->equalTo(':time getAdRecord(ID=18)'));

        $viewer = new AdsViewer($converter, $logger);
        $viewer->fetch(18, 'Mysql', Currency::RUB);

        // DAEMON
        $logger = $this->createMock(Logger::class);
        $logger
            ->expects($this->once())
            ->method('add')
            ->with($this->equalTo(':time get_deamon_ad_info(ID=29)'));

        $viewer = new AdsViewer($converter, $logger);
        $ads = $viewer->fetch(29, 'Daemon', Currency::RUB);

        // Проверяем валюту и стоимость объявления
        $this->assertEquals(Currency::RUB, $ads->currency);
        $this->assertEquals('690.86', $ads->price);
    }
}