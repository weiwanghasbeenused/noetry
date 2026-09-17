<?php 
function renderListEntry($content, $url, $idx, $extra_cls = []){
    $style = $idx != -1 ? 'z-index: ' . 50 - $idx . ';' : '';
    $body = '';
    $background = '';
    $thumbnail = '';
    $cls = array_merge(array('list-entry'), $extra_cls);
    
    
    $output = '<div class="' . implode(' ', $cls) . '" style="'.$style.'" data-slug="'.$url.'">'.$background.'<div class="entry-inner essay-inner">'.$content.'</div></div>';
    return $output;
}
