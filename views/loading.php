<?php
function generateLoading($id, $buttons = array(), $text='載入中...') {
    $buttons_html = '';
    foreach($buttons as $button) {
        if($button === 'cancel') {
            $buttons_html .= '<div class="loading-button bar-button button" data-action="cancel">取消</div>';
        }else if($button === 'quit') {
            $buttons_html .= '<div class="loading-button bar-button button red" data-action="leave">放棄</div>';
        }
    }
    $buttons_html = $buttons_html ? '<div class="loading-buttons">'.$buttons_html.'</div>' : '';
    return '<div id="'.$id.'" class="full-vw full-vh fixed loading-container">
        <div class="loading-icon full-center-icon icon"></div>
        <div class="loading-message body">'.$text.'</div>
        '.$buttons_html.'
    </div>';
}