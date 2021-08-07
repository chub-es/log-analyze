<?php

declare(strict_types=1);

namespace Analyze;

abstract class Error
{
    /**
     * Счетчик успешных
     */
    private $counterSuccess = 0;
    /**
     * Счетчик отказов
     */
    private $counterErrors = 0;

    /**
     * Массив выявленных отказов
     */
    private $list = array();

    /**
     * Величина, всегда инится в конце обработчика, т.к. всегда равна предыдущей записи
     */
    private $previousResponseTime = '';

    /**
     * Добавляет запись в коллекцию
     * 
     * @param string
     */
    protected function Add(string $line): void
    {
        $this->list[] = $line;
    }

    /**
     * 
     * 
     * @param array
     */
    protected function CheckLine($lineValues)
    {
        list($time, $httpCode, $responseTime) = $lineValues;

        $httpCode >= 500 || $responseTime >= $this->responseTime === TRUE
            ? $this->counterErrors++ : $this->counterSuccess++;

        # Рассчитываем процент доли отказов
        $calcAvailability = round((100 * $this->counterErrors) / ($this->counterSuccess + $this->counterErrors), 1);
        if ($calcAvailability >= $this->availabilityLevel) {
            
            # Пустой при первой итерации
            if (empty($this->previousResponseTime)) {
                $this->previousResponseTime = $time;
            }

            $this->Add($this->previousResponseTime . "\t$time\t$calcAvailability" . PHP_EOL);
        }

        $this->previousResponseTime = $time;
    }

    /**
     * Возвращает список ошибок
     */
    public function getList(): array
    {
        return $this->list;
    }
}