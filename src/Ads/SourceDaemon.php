<?php

namespace StayCalm1\Tt2\Ads;

use Exception;

use StayCalm1\Tt2\Currencies\Currency;

/**
 * Представляет источник данных - кеширующий демон
 */
class SourceDaemon implements Source
{
    public function __construct(/* Настройки для источника - кэширующий демон */)
    {
    }

    /**
     * @param mixed $id
     * @return \StayCalm1\Tt2\Ads\Ad
     * @throws \StayCalm1\Tt2\Ads\UnrecoverableException
     */
    public function fetch($id)
    {
        try {
            $result = get_deamon_ad_info($id);
            $set = explode("\t", $result);

            // Считаем, что от нашего демона всегда приходят правильные данные
            $ad = new Ad();
            $ad->id = $set[0];
            $ad->name = $set[3];
            $ad->text = $set[4];
            $ad->price = $set[5];
            $ad->currency = Currency::USD;

            return $ad;
        } catch (Exception $e) {
            // @todo Преобразуем разные виды ошибок в зависимости от того, можем ли мы их обработать или нет
            throw new UnrecoverableException('We faced troubles', 500, $e);
        }
    }

    /**
     * Возвращает источник объявлений.
     *
     * @return string
     */
    public function getSourceName()
    {
        return 'get_deamon_ad_info';
    }
}