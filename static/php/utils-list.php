<?php
require_once(__DIR__ . '/utils.php');
function addItemToList($item, $list){
    $output = $list;
    $datetime = processDate($item['begin']);

    if(!isset($output[$datetime['year']])) {
        $output[$datetime['year']] = array();
    }
    if(!isset($output[$datetime['year']][$datetime['month']])) {
        $output[$datetime['year']][$datetime['month']] = array();
    }
    $day = $datetime['day'] . '-' . $datetime['day-of-week'];
    if(!isset($output[$datetime['year']][$datetime['month']][$day])) {
        $output[$datetime['year']][$datetime['month']][$day] = array();
    }
    $item['time'] = $datetime['hour'] . ':' . $datetime['minute'];
    $item['m'] = $datetime['m'];
    $output[$datetime['year']][$datetime['month']][$day][] = $item;
    return $output;
}