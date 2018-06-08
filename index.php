<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use StayCalm1\Tt2\Ads\AdsViewer;
use StayCalm1\Tt2\Currencies\Converter;
use StayCalm1\Tt2\Currencies\Currency;
use StayCalm1\Tt2\Currencies\Source;
use StayCalm1\Tt2\Logger as LoggerCustom;

require __DIR__ . '/vendor/autoload.php';

// Конвертер валют
$converter = new Converter(new Source());

// Logger
$loggerOriginal = new Logger('name');
$loggerOriginal->pushHandler(new StreamHandler('log.txt', Logger::INFO));
$tz = new DateTimeZone('Europe/Moscow');

// Создаём отключенный logger
$logger = new LoggerCustom($tz, $loggerOriginal, true);

// @todo Добавить валидацию и фильтры
$id = $_GET['id'] ?? 10;
$from = $_GET['from'] ?? 'Mysql';

$viewer = new AdsViewer($converter, $logger);
$ad = $viewer->fetch($id, $from, Currency::RUB);

?>

<h1><?= $ad->name ?></h1>
<p><?= $ad->text ?></p>
<p><?= $ad->price ?></p>