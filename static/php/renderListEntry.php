<?php 
function renderListEntry($content, $url, $idx, $extra_cls = []){
    // global $item_style;
    $id = 'essay-entry-' . $idx;
    $style = 'z-index: ' . 50 - $idx . ';';
    $body = '';
    $background = '';
    $thumbnail = '';
    $cls = array_merge(array('list-entry'), $extra_cls);
    
    
    $output = '<div id="'.$id.'" class="' . implode(' ', $cls) . '" style="'.$style.'" data-slug="'.$url.'">'.$background.'<div class="entry-inner essay-inner">'.$content.'</div></div>';
    return $output;
}
