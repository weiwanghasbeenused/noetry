<?php 
function getView($uri){
    if(!$uri[1]) return 'home';
    if($uri[1] === 'essays') {
        if(count($uri) === 2)
            return 'essay-list';
        else if(count($uri) === 3)
            return 'essay-detail';
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
    return '';
}