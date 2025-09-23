<?php
require_once(__DIR__ . '/utils.php');
function handlePoem($raw){
    $output = $raw;
    $diaries = json_decode($output['diaries'], true);
    $points = [];
    foreach($diaries as $d) {
        $temp = explode(' ', $d['points']);
        $p = [];
        foreach($temp as $key => $t) {
            $p[] = $t;
            if($key % 2 === 1) {
                $points[] = $p;
                $p = [];
            }
        }
        
    }
    $output['thumbnail'] = null;
    if(isset($output['media'])) {
        $output['media'] = json_decode($output['media'], true);
        foreach($output['media'] as $m) {
            if(strpos($m['caption'], '[thumbnail]') !== false) {
                $output['thumbnail'] = array(
                    'id' => $m['id'],
                    'type' => $m['type'],
                    'src' => m_url($m)
                );
            }
        }
    }
    $output['points'] = sortPoints($points);

    $datetime = processDate($raw['begin']);
    $output['time'] = $datetime['hour'] . ':' . $datetime['minute'];
    $output['m'] = $datetime['m'];

    return $output;
}