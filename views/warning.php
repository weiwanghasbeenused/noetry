<?php
function generateWarning($id, $buttons = array(), $text='') {
    $buttons_html = '';
    foreach($buttons as $button) {
        if($button === 'cancel') {
            $buttons_html .= '<div class="warning-button bar-button fit-parent button" data-action="cancel">取消</div>';
        }else if($button === 'quit') {
            $buttons_html .= '<div class="warning-button bar-button fit-parent button red bold" data-action="quit">放棄</div>';
        }
    }
    $buttons_html = $buttons_html ? '<div class="warning-buttons">'.$buttons_html.'</div>' : '';
    return '<div class="warning-wrapper full-vw full-vh fixed" data-hidden="1"><div id="'.$id.'" class="warning-container">
        <div class="warning-message body small">'.$text.'</div>
        '.$buttons_html.'
    </div></div>';
}