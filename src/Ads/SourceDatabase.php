<?php

namespace StayCalm1\Tt2\Ads;

use StayCalm1\Tt2\Currencies\Currency;

/**
 * Представляет источник данных - БД
 */
class SourceDatabase implements Source
{
    public function __construct(/* Настройки для источника - БД */)
    {
    }

    /**
     * @param int $id
     * @return \StayCalm1\Tt2\Ads\Ad
     * @throws \StayCalm1\Tt2\Ads\UnrecoverableException
     */
    public function fetch($id)
    {
        try {
            $result = getAdRecord($id);

            // Считаем, что от нашего демона всегда приходят правильные данные
            $ad = new Ad();
            $ad->id = $result['id'];
            $ad->name = $result['name'];
            $ad->text = $result['text'];
            $ad->price = $result['price'];
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
        return 'getAdRecord';
    }
}