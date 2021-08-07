<?php

require __DIR__ . './vendor/autoload.php';

use \Analyze\Log,
    \Analyze\Performance\Timer,
    \Analyze\Performance\Memory;

# Фиксируем время выполнения и объём потребляемой памяти
Timer::start();

$params = getopt('u:t:');
$analyze = new Log('php://stdin');
$resp = $analyze->setParams($params)
    ->Read()
    ->getList();

# Фиксируем разницу времени выполнения и объём потребляемой памяти
$timer = Timer::finish();
$memory = Memory::finish();

echo "Время выполнения скрипта: $timer сек." . PHP_EOL;
echo "Скушано памяти: $memory байт";