<?php
if(!function_exists('renderListEntry'))
    require_once(__DIR__ . '/renderListEntry.php');
if(!function_exists('sanitizeEntryBody'))
    require_once(__DIR__ . '/sanitizeEntryBody.php');
function renderEssayEntry($entry, $list_type, $idx=-1){
    if($entry['thumbnail'] && $list_type !== 'grid') {
        $thumbnail = '<div class="thumbnail-wrapper essay-thumbnail-wrapper"><img class="thumbnail" src="'.$entry['thumbnail']['src'].'"></div>';
    }
    if($entry['name2'] && $entry['deck']) {
        $body = "<div class='entry-body essay-body body list-text essay-text body'>
            <div class='essay-title bold'>$entry[name2]</div>
            $entry[deck]
        </div>";
    } else {
        $cls[] = 'no-essay';
        $body = "<div class='entry-body essay-body list-text essay-text body'>
                $entry[body]
        </div>";
    }
    $time = '';
    $header = '<div class="entry-header">';
    $location = '<div class="entry-location essay-location small bold">大安站星巴克</div>';
    if($list_type === 'rows' || $list_type === 'calendar')
        $time = '<div class="entry-time essay-time small bold">'.$entry['time'].'</div>';
    else if($list_type === 'grid') {
        $date = str_replace('/', '<span class="date-separator"> / </span>', $entry['date']);
        $time = '<div class="entry-time essay-time small bold">'.$date.'</div>';
    }
    $header .= $time . $location . '</div>';
    $content = $header  . $body;
    return renderListEntry($content, $entry['url'], $idx, ['essay-entry']);
}