<?php 
if(!isset($current_version))
    require_once(__DIR__ . '/config-version.php');
function getView($uri, $v=1){
    global $current_version;
    if(!$uri[1]) return 'home';
    if(strpos($uri[1], 'essays') !== false) {
        if(count($uri) === 2)
            return $v == $current_version ? 'essay-list' : 'essay-list-v' . $v;
        else if(count($uri) === 3) {
            return $v == $current_version ? 'essay-detail' : 'essay-detail-v' . $v;
        }
            
    }
    if($uri[1] === 'diary') {
        if(count($uri) === 2)
            return 'diary';
        else if(count($uri) === 3)
            return 'diary-detail';
    }

    if($uri[1] === 'add') {
        return 'add';
    }
    if($uri[1] === 'refresh') {
        return 'refresh';
    }
    return '';
}