<?php

function getAdRecord($id)
{
    // пример ответа
    return [
        'id' => $id,
        'name' => 'AdName_FromMySQL',
        'text' => 'AdText_FromMySQL',
        'keywords' => 'Some Keywords',
        'price' => 10, // 10$
    ];
}

function get_deamon_ad_info($id)
{
    // пример ответа: строка разделенная табуляцией
    return "{$id}\t235678\t12348\tAdName_FromDaemon\tAdText_FromDaemon\t11";
}