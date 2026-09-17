<?php

function sanitizeEntryBody($str){
    $output = preg_replace('/<img\b[^>]*>\s*(<br\s*\/?>)?/i', '', $str);

    return $output;
}
