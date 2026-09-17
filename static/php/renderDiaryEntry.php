<?php
if(!function_exists('renderListEntry'))
    require_once(__DIR__ . '/renderListEntry.php');
if(!function_exists('sanitizeEntryBody'))
    require_once(__DIR__ . '/sanitizeEntryBody.php');
function renderDiaryEntry($entry, $idx=-1){
    // global $item_style;
    $style = '';
    // $background = '';
    $cls = array('diary-entry');
    if($idx === 0)
        $cls[] = 'add-new';
    $url = $entry['url'] ?? '';
    $tangled = $entry['tangled'] ? '<div class="tangled-wrapper"><img class="tangled" src="'.$entry['tangled']['src'].'" /></div>': '';
    $thumbnail = '';
    if($entry['thumbnail']) {
        $thumbnail = '<div class="thumbnail-wrapper diary-thumbnail-wrapper"><img class="thumbnail" src="'.$entry['thumbnail']['src'].'"></div>';
    }
    $body = sanitizeEntryBody($entry['body']);
    $content =  $tangled . '<div class="right-group"><div class="entry-header entry-time diary-time small bold">'.$entry['time'].'</div>
        <div class="diary-body">
            <div class="list-text diary-text body">' . $body. '</div>
            '.$thumbnail.'
        </div></div>';
    return renderListEntry($content, $url, $idx, $cls);
}