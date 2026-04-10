<?php 
function getView($uri, $v=1){
    if(!$uri[1]) return 'home';
    if($uri[1] === 'essays') {
        if(count($uri) === 2)
            return $v == 1 ? 'essay-list' : 'essay-list-v' . $v;
        else if(count($uri) === 3) {
            return $v == 1 ? 'essay-detail' : 'essay-detail-v' . $v;
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