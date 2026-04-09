<?php

function getHomeListItems($db){
    $sql = "SELECT o.name1, o.url FROM objects o JOIN wires w ON w.toid = o.id AND w.fromid = 0 AND w.active = 1 WHERE o.active = 1 ORDER BY o.name1";
    $result = $db->query($sql);
    $output = array();
    while($row = $result->fetch_assoc())
        $output[] = $row;

    return $output;
}