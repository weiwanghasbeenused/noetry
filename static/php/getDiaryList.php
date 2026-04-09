<?php
// require_once(__DIR__ . '/getList.php');
require_once(__DIR__ . '/utils-list.php');
require_once(__DIR__. '/handleDiary.php');


function generateAddNew(){
    return array(
        'body' => '寫下一些生活的吉光片羽....',
        'begin' => date('Y-m-d h:i:s', time()),
        'media' => null
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
    $add_new = handleDiary(generateAddNew());
    $output = addItemToList($add_new, $output);
    
    while($row = $result->fetch_assoc()) {
        $item = handleDiary($row);
        $output = addItemToList($item, $output);
    }
    return $output;
}
