<?php

function renderDiaryEntryV2($diary, $idx=-1){
    global $item_style;
    $style = '';
    $background = '';
    if($item_style == 2 && $idx !== 0) {
        $background = '<div class="svg-background">
                    <?xml version="1.0" encoding="UTF-8"?><svg xmlns="http://www.w3.org/2000/svg" width="360" height="108" viewBox="0 0 360 108" preserveAspectRatio="none"><defs><style>.cls-1{fill:#fff;}</style></defs><polygon class="cls-1" points="'.$diary['address1'].'"/></svg>
                </div>';        
    }
    $cls = array('list-entry', 'diary-entry');
    if($idx === 0)
        $cls[] = 'add-new';
    $thumbnail = '';
    $header = [];
    $header[] = '<span class="entry-header-section diary-header-section diary-header-time">' . $diary['time'] . '</span>';
    if($diary['address2']) {
        $header[] = '<span class="entry-header-section diary-header-section diary-header-location">' . $diary['address2'] . '</span>';
    }
    if($diary['state']) {
        $header[] = '<span class="entry-header-section diary-header-section diary-header-weather">' . $diary['state'] . '</span>';
    }
    $header = implode('<span class="entry-header-separator"></span>', $header);
    $output = '<div class="' . implode(' ', $cls) . '" style="'.$style.'">' .$background . '<div class="diary-content ">
    <div class="entry-header small">'.$header.'</div>
        <div class="diary-body">
            <div class="list-text diary-text body">' . $diary['body']. '</div>
            '.$thumbnail.'
        </div>
        </div></div>';
    return $output;
}