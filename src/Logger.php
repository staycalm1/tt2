<?php

namespace StayCalm1\Tt2;

use Monolog\Logger as LoggerOriginal;
use DateTimeZone;
use DateTime;

/**
 * Надстройка над уже существующим logger'ом,
 * добавляющая функционал включения/выключения +
 * работу с временными зонами.
 *
 * @todo Добавить тесты
 */
class Logger
{
    /**
     * @var \DateTimeZone
     */
    protected $tz;

    /**
     * @var \Monolog\Logger;
     */
    protected $loggerOriginal;

    /**
     * @var bool Включен / Выключен
     */
    protected $status;

    /**
     * @param \DateTimeZone $tz
     * @param \Monolog\Logger $loggerOriginal
     * @param bool $status
     */
    public function __construct(DateTimeZone $tz, LoggerOriginal $loggerOriginal, $status)
    {
        $this->tz = $tz;
        $this->loggerOriginal = $loggerOriginal;
        $this->status = $status;
    }

    public function add($message)
    {
        // Если logger выключен
        if (!$this->status) {
            return;
        }

        $now = new DateTime('now', $this->tz);

        // Добавляем текущее время и записываем в лог
        $this->loggerOriginal->info(str_replace(':time', $now->format('Y-m-d H:i:s'), $message));
    }
}