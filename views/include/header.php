<?php

function renderHeader($config, $id, $cls=array()){
    $parts = array();
    foreach($config as $key => $side) {
        if($key === 'title') {
            $parts[$key] = '<h1 class="title page-title medium bold">'.$side.'</h1>';
            continue;
        } 
        $parts[$key] = '';
        foreach($side as $element) {
            if($element === 'menu') {
                $parts[$key] .= '<div class="menu-toggle menu-icon icon button"></div>';
            } else if($element === 'search') {
                $parts[$key] .= '<div class="search-icon icon button" data-href="/search"></div>';
            } else if($element === 'generate') {
                $parts[$key] .= '<div class="wand-icon icon button" data-href="/review"></div>';
            } else if($element === 'add') {
                $parts[$key] .= '<div class="plus-icon icon button" data-href="/add-diary"></div>';
            } else if($element === 'next-step-text') {
                $parts[$key] .= '<div class="next-step-button text-button button small" data-href="" data-status="0">下一步</div>';
            } else if($element === 'edit-text') {
                $parts[$key] .= '<div class="edit-button text-button button small" data-href="" data-status="1">編輯</div>';
            } else if($element === 'cancel-text') {
                $parts[$key] .= '<div class="cancel-button text-button button small" data-href="" data-status="1">取消</div>';
            } else if($element === 'esc') {
                $parts[$key] .= '<div class="esc-icon icon button" data-href=""></div>';
            } else if($element === 'locator') {
                $parts[$key] .= '<div class="locator-icon icon button"></div>';
            }
        }
    }
    $cls = is_string($cls) ? array($cls, 'header') : (is_array($cls) ? array_merge($cls, array('header')) : array('header'));
    $cls_str = implode(' ', $cls);
    $output = '<header id="'.$id.'" class="'.$cls_str.'">
        <div class="header-left header-section">' . $parts['left'] . '</div>
        <div class="header-center header-section">' . $parts['title'] . '</div>
        <div class="header-right header-section">' . $parts['right'] . '</div>
    </header>';
    return $output;
}