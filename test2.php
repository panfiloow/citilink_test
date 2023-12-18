<?php

/** 
 * Тестовое задание 2
 * 
 * Задание 2. Работа с массивами и строками.
 *
 * Есть список временных интервалов (интервалы записаны в формате чч:мм-чч:мм).
 *
 * Необходимо написать две функции:
 *
 * 1)
 * Первая функция должна проверять временной интервал на валидность
 * принимать она будет один параметр: 
 * временной интервал (строка в формате чч:мм-чч:мм)
 * возвращать boolean
 *
 * 2)
 * Вторая функция должна проверять "наложение интервалов" при попытке 
 * добавить новый интервал в список существующих
 * принимать она будет один параметр: временной интервал строка  чч:мм-чч:мм. 
 * Учесть переход времени на следующий день
 * возвращать boolean
 *
 * "наложение интервалов" - это когда в промежутке
 * между началом и окончанием одного интервала,
 * встречается начало, окончание или то и другое одновременно, другого интервала
 * Пример временного интервала: 10:00-14:00
 * 
 * PHP version 8
 * 
 * @category Test_Class2
 * @package  Test_Class2
 * @author   Author Ilya Panfilov <author@domain.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 * @charset  UTF-8
 */

/**
 * Функция для проверки временного интервала на валидность
 *
 * @param string $timeInterval Временной интервал в формате чч:мм-чч:мм
 *
 * @return bool Результат проверки временного интервала на валидность
 */
function validateTimeInterval(string $timeInterval): bool 
{ 
    if (strlen($timeInterval != 11)) {
        return false;
    }
    if (!preg_match('/^([01][0-9]|2[0-3])(:([0-5][0-9]))-([01][0-9]|2[0-3])(:([0-5][0-9]))$/', $timeInterval)) {
        return false;
    } 
    return true; 
}

/**
 * Функция для проверки "наложения" временных интервалов
 *
 * @param string $timeInterval Временной интервал в формате чч:мм-чч:мм
 *
 * @return bool Результат проверки на наложение интервалов из заданного списка и передаваемого True - нет наложения False - есть
 */
function checkIntervalOverlapping($timeInterval) : bool
{
    $list = array (
    '09:00-11:00',
    '11:00-13:00',
    '15:00-16:00',
    '17:00-20:00',
    '20:30-21:30',
    '21:30-22:30',
     );

    $timeParts = explode('-', $timeInterval); 
    $timeStartPieces = explode(':', $timeParts[0]);
    $timeEndPieces = explode(':', $timeParts[1]);
    // Время начала проверяемого интервала в минутах
    $startTime = (int) $timeStartPieces[0] * 60 + (int) $timeStartPieces[1];
    // Время конца проверяемого интервала в минутах
    $endTime = (int) $timeEndPieces[0] * 60 + (int) $timeEndPieces[1];
    foreach ($list as $item) {
        $result = false;
        $itemTimeParts = explode('-', $item);
        $itemStartPieces = explode(':', $itemTimeParts[0]);
        $itemEndPieces = explode(':', $itemTimeParts[1]);
        // Время начала  интервала из списка в минутах
        $itemStartTime = (int) $itemStartPieces[0] * 60 + (int) $itemStartPieces[1];
        // Время конца  интервала из списка в минутах
        $itemEndTime = (int) $itemEndPieces[0] * 60 + (int) $itemEndPieces[1];
        // если нет перехода на следующий день и нет пересечения
        if (($startTime < $endTime && $itemStartTime < $itemEndTime) && ($endTime <= $itemStartTime || $itemEndTime <= $startTime)) {
            $result = true;
        }
        //если 1 переход на следующий день и нет пересечений
        if ((($startTime < $endTime && $itemStartTime > $itemEndTime) || ($startTime >= $endTime && $itemStartTime <= $itemEndTime)) &&(($startTime >= $itemEndTime && $endTime <= $itemStartTime) || ($itemStartTime >= $endTime && $itemEndTime <= $startTime))) {
            $result = true;
        }
        if (!$result) {
            return false;
        }
    }
    return true;
}

// пример использования функции validateTimeInterval
echo validateTimeInterval('02:00-03:00') ? 'Временной интервал валиден' : 'Временной интервал невалиден';
echo '<br>';
// пример использования функции checkIntervalOverlapping
echo checkIntervalOverlapping('11:20-2:00') ? 'Наложений не найдено' : 'Наложение найдено';

