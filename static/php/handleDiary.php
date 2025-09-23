<?php
require_once(__DIR__ . '/utils.php');
function handleDiary($raw){
    $output = $raw;
    $output['thumbnail'] = null;
    $output['tangled'] = null;
    if(isset($output['media'])) {
        $output['media'] = json_decode($output['media'], true);
        foreach($output['media'] as $m) {
            if(strpos($m['caption'], '[thumbnail]') !== false) {
                $output['thumbnail'] = array(
                    'id' => $m['id'],
                    'type' => $m['type'],
                    'src' => m_url($m)
                );
            } else if(strpos($m['caption'], '[tangled]') !== false) {
                $output['tangled'] = array(
                    'id' => $m['id'],
                    'type' => $m['type'],
                    'src' => m_url($m)
                );
            }
                
        }
    }
    $datetime = processDate($raw['begin']);
    $output['time'] = $datetime['hour'] . ':' . $datetime['minute'];
    $output['m'] = $datetime['m'];
    

    return $output;
}