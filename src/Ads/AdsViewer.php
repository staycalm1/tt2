<?php

namespace StayCalm1\Tt2\Ads;

use StayCalm1\Tt2\Currencies\Converter;
use StayCalm1\Tt2\Logger;

class AdsViewer
{
    protected $converter;
    protected $logger;

    public function __construct(Converter $converter, Logger $logger)
    {
        $this->converter = $converter;
        $this->logger = $logger;
    }

    /**
     * @param int $id Идентификатор объявления.
     * @param string $fromSource Из какого источника брать.
     * @param string $toCurrency В какую валюту перевести стоимость.
     * @return \StayCalm1\Tt2\Ads\Ad
     * @throws \StayCalm1\Tt2\Ads\UnrecoverableException
     * @throws \StayCalm1\Tt2\Currencies\UnrecoverableException
     */
    public function fetch($id, $fromSource, $toCurrency)
    {
        /** @var \StayCalm1\Tt2\Ads\Source $source */
        $source = null;

        switch ($fromSource) {
            case 'Daemon':
                $source = new SourceDaemon();
                break;
            case 'Mysql':
                $source = new SourceDatabase();
                break;
            default:
                throw new UnrecoverableException();
        }

        // Сохраняем факт запроса
        $this->logger->add(':time ' . $source->getSourceName() . '(ID=' . $id . ')');

        // Отправляем запрос к источнику объявлений
        $adOriginal = $source->fetch($id);

        // Меняем валюту и стоимость в зависимости от требований
        $ad = clone $adOriginal;
        $ad->price = $this->converter->convert($adOriginal->currency, $toCurrency, $adOriginal->price);
        $ad->currency = $toCurrency;

        return $ad;
    }
}