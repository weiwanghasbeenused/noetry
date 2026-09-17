<?php
if(!function_exists('renderListEntry'))
    require_once(__DIR__ . '/renderListEntry.php');
if(!function_exists('sanitizeEntryBody'))
    require_once(__DIR__ . '/sanitizeEntryBody.php');
function renderDiaryEntry($entry, $idx=-1, $ex_cls=[]){
    // global $item_style;
    $style = '';
    // $background = '';
    $cls = array_merge(array('diary-entry'), $ex_cls);
    if($idx === 0)
        $cls[] = 'add-new';
    $url = $entry['url'] ?? '';
    $tangled = $entry['tangled'] ? '<div class="tangled-wrapper"><img class="tangled" src="'.$entry['tangled']['src'].'" /></div>': '';
    $thumbnail = '';
    if($entry['thumbnail']) {
        $thumbnail = '<div class="thumbnail-wrapper diary-thumbnail-wrapper"><img class="thumbnail" src="'.$entry['thumbnail']['src'].'"></div>';
    }
    $removeImages = !in_array('in-essay-detail', $ex_cls);
    $body = sanitizeEntryBody($entry['body'], $removeImages);
    $header = $entry['time'];
    if(in_array('in-essay-detail', $ex_cls))
        $header .= '<div class="icon diary-header-more"></div>';
    $header = '<div class="entry-header entry-time diary-time small bold">' . $header . '</div>';
    $content =  $tangled . '<div class="right-group">'.
        $header . 
        '<div class="diary-body">
            <div class="list-text diary-text body">' . $body. '</div>
            '.$thumbnail.'
        </div></div>';
    return renderListEntry($content, $url, $idx, $cls);
}