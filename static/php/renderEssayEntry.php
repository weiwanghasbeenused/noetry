<?php
if(!function_exists('renderListEntry'))
    require_once(__DIR__ . '/renderListEntry.php');
if(!function_exists('sanitizeEntryBody'))
    require_once(__DIR__ . '/sanitizeEntryBody.php');
function renderEssayEntry($entry, $list_type, $idx=-1){
    global $db;
    if($entry['thumbnail'] && $list_type !== 'grid') {
        $thumbnail = '<div class="thumbnail-wrapper essay-thumbnail-wrapper"><img class="thumbnail" src="'.$entry['thumbnail']['src'].'"></div>';
    }
    if($entry['name2'] && $entry['deck']) {
        $body = "<div class='entry-body body list-text body'>
            <div class='essay-title bold'>$entry[name2]</div>
            $entry[deck]
        </div>";
    } else {
        $cls[] = 'no-essay';
        $body = "<div class='entry-body list-text body'>
                $entry[body]
        </div>";
    }
    // $time = '';
    $header = '';
    // $diary_count = false;
    // $location = '<div class="entry-location essay-location small bold">大安站星巴克</div>';
    $sql = "SELECT count(o.id) FROM objects o WHERE o.id IN({$entry['state']}) AND o.active = 1";
    $result = $db->query($sql)->fetch_assoc();
    $diary_count = array_values($result)[0];
    if($diary_count)
        $header = '<div class="diary-count">共有 ' . $diary_count . ' 則心雜音</div>';
    if($list_type === 'grid') {
        $date = str_replace('/', '<span class="date-separator"> / </span>', $entry['date']);
        $time = '<div class="entry-time essay-time small bold">'.$date.'</div>';
        $header = '<div class="entry-header">' . $time . '</div>' . $header;
    }
    $header = '<div class="entry-header small bold">' . $header . '</div>';
    $content = $header  . $body;
    return renderListEntry($content, $entry['url'], $idx, ['essay-entry']);
}