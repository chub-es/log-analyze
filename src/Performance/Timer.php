<?php

namespace Analyze\Performance;

/**
 * Класс для измерения времени выполнения скрипта PHP
 */
final class Timer
{
    /**
     * @var float время начала выполнения скрипта
     */
    private static $start = .0;
 
    /**
     * Начало выполнения
     */
    public static function start()
    {
        self::$start = microtime(true);
    }
 
    /**
     * Разница между текущей меткой времени и меткой self::$start
     * @return float
     */
    public static function finish()
    {
        return microtime(true) - self::$start;
    }
}