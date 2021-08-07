<?php

namespace Analyze\Performance;

final class Memory
{
    /**
     * @var int время начала выполнения скрипта
     */
    private static $memory = 0;
 
    /**
     * Начало выполнения
     */
    public static function start()
    {
        self::$memory = memory_get_usage();
    }
 
    /**
     * Разница между текущей меткой потребляемой памяти и меткой self::$memory
     * @return int
     */
    public static function finish()
    {
        return memory_get_usage() - self::$memory;
    }
}