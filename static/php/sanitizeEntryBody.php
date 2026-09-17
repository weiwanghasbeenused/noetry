<?php

function sanitizeEntryBody($str, $removeImages=true){
    $output = $str;
    if($removeImages)
        $output = preg_replace('/<img\b[^>]*>\s*(<br\s*\/?>)?/i', '', $str);

    $output = preg_replace('/^(\s*<br\s*\/?>)+/i', '', $output);
    $output = preg_replace('/(<br\s*\/?>\s*)+$/i', '', $output);

    return $output;
}
