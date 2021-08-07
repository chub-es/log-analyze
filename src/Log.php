<?php

declare(strict_types=1);

namespace Analyze;

// use \Analyze\Rejection;

use \Analyze\Exception\LogException,
    \Analyze\Error;

final class Log extends Error
{
    /**
     * @var resource
     */
    private $handler;

    /**
     * @var float Минимально допустимый уровень доступности
     */
    protected $availabilityLevel = 99.9;

    /**
     * @var float Приемлемое время ответа
     */
    protected $responseTime = 45;

    /**
     * Конструктор
     */
    public function __construct(string $filename)
    {
        if (empty($filename)) {
            throw new LogException('Не определен источник данных');
        }

        # Открываем ресурс
        $this->handler = @fopen($filename, 'r');
        if ($this->handler === FALSE) {
            throw new LogException('Не удалось открыть файл');
        }
    }

    /**
     * Деструктор
     */
    public function __destruct()
    {
        @fclose($this->handler);
    }

    /**
     * Инит параметры
     * 
     * @param array
     */
    public function setParams(array $params): Log
    {
        if (!is_null($params['u'])) {
            $this->availabilityLevel = $params['u'];
        }

        if (!is_null($params['t'])) {
            $this->responseTime = $params['t'];
        }

        return $this;
    }

    /**
     * Читает файл
     */
    public function Read(): Log
    {
        while($this->isEndFile())
        {
            $line = fgets($this->handler);
            if ($line === FALSE) {
                continue;
            }

            $lineValues = $this->getDataFromLine($line);
            $this->CheckLine($lineValues);
        }
        return $this;
    }

    /**
     * Проверяет достигнут ли конец файла
     * 
     * @return bool
     */
    private function isEndFile(): bool
    {
        return !feof($this->handler);
    }

    /**
     * Метод возвращает время начала выполнения, код ответа и время обработки запроса
     * 
     * @param string
     * @return array
     */
    private function getDataFromLine(string $line): ?array
    {
        preg_match_all(
            '(\d{2}:\d{2}:\d{2}\s|\d{2}.\d{6}|\s\d{3}\s)',
            $line,
            $lineValues
        );

        $lineValues = current($lineValues);
        array_walk($lineValues, function(&$value) {
            $value = trim($value);
        });

        return $lineValues;
    }
}