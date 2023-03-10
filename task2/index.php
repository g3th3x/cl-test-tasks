<?php

/**
 * @charset UTF-8
 *
 * Задание 2. Работа с массивами и строками.
 *
 * Есть список временных интервалов (интервалы записаны в формате чч:мм-чч:мм).
 *
 * Необходимо написать две функции:
 *
 *
 * Первая функция должна проверять временной интервал на валидность
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 * 	возвращать boolean
 *
 *
 * Вторая функция должна проверять "наложение интервалов" при попытке добавить новый интервал в список существующих
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм). Учесть переход времени на следующий день
 *  возвращать boolean
 *
 *  "наложение интервалов" - это когда в промежутке между началом и окончанием одного интервала,
 *   встречается начало, окончание или то и другое одновременно, другого интервала
 *
 *
 *
 *  пример:
 *
 *  есть интервалы
 *  	"10:00-14:00"
 *  	"16:00-20:00"
 *
 *  пытаемся добавить еще один интервал
 *  	"09:00-11:00" => произошло наложение
 *  	"11:00-13:00" => произошло наложение
 *  	"14:00-16:00" => наложения нет
 *  	"14:00-17:00" => произошло наложение
 */

# Можно использовать список:

// $list = array(
//     "10:00-14:00",
//     "16:00-20:00"
// );

// $trying = array(
// "09:00-11:00",
// "11:00-13:00",
// "14:00-16:00",
// "14:00-17:00",
// );

$list = array(
	'09:00-11:00',
	'11:00-13:00',
	'15:00-16:00',
	'17:00-20:00',
	'20:30-21:30',
	'21:30-22:30',
);

$trying = array(
    "09:00-11:00",
    "11:00-13:00",
    "14:00-16:00",
    "14:00-17:00",
    "00:00-14:00",
    "16:00-20:00",
    "24:00-21:00",
    "23:61-21:61",
    "23:00-21:61",
    "23:61-21:00",
    "01:00-24:00",
    "20:30-17:30",
    "08:00-08:30",
    "09:09-08:08",
    "23:00-08:15",
);

function is_valid_time($time){
    return (preg_match_all("#^(?:2[0-3]|[01][0-9]):[0-5][0-9]-(?:2[0-3]|[01][0-9]):[0-5][0-9]$#", $time, $match)) ? true : false;
}

function is_crossing($timeTry){
    global $list;

    preg_match_all("#^((?:2[0-3]|[01][0-9]):[0-5][0-9])-((?:2[0-3]|[01][0-9]):[0-5][0-9])$#", $timeTry, $match);
    $time2_start = $match[1][0];
    $time2_end = $match[2][0];

    if($time2_start > $time2_end) {
        $overTime[] = $time2_start."-23:59";
        $overTime[] = "00:00-".$time2_end;
        foreach($overTime as $time) {
            if(is_crossing($time)) {
                return true;
            }
        }
            return false;
    }

    foreach($list as $time) {
        preg_match_all("#^((?:2[0-3]|[01][0-9]):[0-5][0-9])-((?:2[0-3]|[01][0-9]):[0-5][0-9])$#", $time, $match);
        $time1_start = $match[1][0];
        $time1_end = $match[2][0];
            
        if(strtotime($time1_start) < strtotime($time2_end) and strtotime($time1_end) > strtotime($time2_start)){
            return true;
        }
    }
        return false;
}

function interval_crossing($timeTry){
    if(is_valid_time($timeTry)) {
        if(is_crossing($timeTry)) {
            echo "{$timeTry} => произошло наложение<br>";
        } else {
            echo "{$timeTry} => наложения нет<br>";
        }
    } else {
        echo "ERR: {$timeTry} - ошибка ввода параметра<br>";
    }
}

foreach($trying as $time) {
    interval_crossing($time);
}