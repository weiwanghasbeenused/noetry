<?php
require_once(__DIR__ . '/handleEssay.php');
require_once(__DIR__ . '/utils-list.php');
require_once(__DIR__ . '/sortPoints.php');



function getPoemList($db, $parent_id=0){
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
        , (
            SELECT CONCAT(
                '[',
                COALESCE(GROUP_CONCAT(
                    JSON_OBJECT(
                        'points', o_diaries.address1
                    )
                    ORDER BY FIND_IN_SET(o_diaries.id, REPLACE(o.state, ' ', ''))
                ), ''),
                ']'
            )
            FROM objects o_diaries
            WHERE o_diaries.active = 1
              AND o.state IS NOT NULL
              AND FIND_IN_SET(o_diaries.id, REPLACE(o.state, ' ', '')) > 0
        ) AS diaries
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
    $sql_thumbnail = "INSERT INTO media (`object`, `caption`) VALUES ";
    $sql_thumbnail_arr = array();
    while($row = $result->fetch_assoc()) {
        $item = handlePoem($row);
        if(!isset($item['thumbnail'])) {
            $sql_thumbnail_arr[] = "($item[id], '[thumbnail]')";
        }
        $output = addItemToList($item, $output);
    }
    $sql_thumbnail = $sql_thumbnail . implode(',', $sql_thumbnail_arr);
    // $db->query($sql_thumbnail);
    return $output;
}
