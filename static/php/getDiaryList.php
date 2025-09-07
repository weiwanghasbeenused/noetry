<?php
function processDiaryDate($begin){
    $datetime = new DateTime($begin);
    return array(
        'year' => $datetime->format('Y'),
        'month' => $datetime->format('m'),
        'day' => $datetime->format('d'),
        'hour' => $datetime->format('H'),
        'minute' => $datetime->format('i'),
        'm' => $datetime->format('A')
    );
}
function getDiaryList($db, $parent_id=0){
    $sql = "SET SESSION group_concat_max_len = 1000000";
    $db->query($sql);
    $sql = "SELECT 
        o.*
        , (
            SELECT CONCAT('[', GROUP_CONCAT(
                JSON_OBJECT(
                    'id', m.id,
                    'type', m.type,
                    'hasWebFormat', m.weight,
                    'caption', REPLACE(CONVERT(m.caption USING utf8), '\\r\\n', '')
                )
                ORDER BY m.rank, m.id
            ), ']')
            FROM media m
            WHERE m.object = o.id AND m.active = 1
        ) AS media
        FROM 
            objects o 
        JOIN wires w 
            ON w.toid = o.id 
            AND w.fromid = $parent_id
            AND w.active = 1 
        WHERE o.active = 1 
        ORDER BY o.begin DESC";
    $result = $db->query($sql);
    $output = array();
    // $$previousDatetime = null;
    while($row = $result->fetch_assoc()) {
        
        $item = [...$row];
        $item['media'] = $row['media'] ? json_decode($row['media'], true) : [];
        $datetime = processDiaryDate($item['begin']);
        
        if(!isset($output[$datetime['year']])) {
            $output[$datetime['year']] = array();
        }
        if(!isset($output[$datetime['year']][$datetime['month']])) {
            $output[$datetime['year']][$datetime['month']] = array();
        }
        if(!isset($output[$datetime['year']][$datetime['month']][$datetime['day']])) {
            $output[$datetime['year']][$datetime['month']][$datetime['day']] = array();
        }
        $item['time'] = $datetime['hour'] . ':' . $datetime['minute'];
        $item['m'] = $datetime['m'];
        $output[$datetime['year']][$datetime['month']][$datetime['day']][] = $item;
    }
    return $output;
}