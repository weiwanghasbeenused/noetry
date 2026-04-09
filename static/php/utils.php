<?php
function processDate($begin){
    $datetime = new DateTime($begin);
    return array(
        'year' => $datetime->format('Y'),
        'month' => $datetime->format('m'),
        'day' => $datetime->format('d'),
        'hour' => $datetime->format('H'),
        'minute' => $datetime->format('i'),
        'm' => $datetime->format('A'),
        'day-of-week'  => $datetime->format('D')
    );
}