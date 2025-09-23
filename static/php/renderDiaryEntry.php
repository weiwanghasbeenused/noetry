<?php

function renderDiaryEntry($diary, $idx=-1){
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
    $tangled = $diary['tangled'] ? '<div class="tangled-wrapper"><img class="tangled" src="'.$diary['tangled']['src'].'" /></div>': '';
    $thumbnail = '';
    if($diary['thumbnail']) {
        $thumbnail = '<div class="thumbnail-wrapper diary-thumbnail-wrapper"><img class="thumbnail" src="'.$diary['thumbnail']['src'].'"></div>';
    }
    $output = '<div class="' . implode(' ', $cls) . '" style="'.$style.'">' .$background.$tangled . '<div class="diary-content "><div class="entry-content-header entry-time diary-time small bold">'.$diary['time'].'</div><div class="list-text diary-text body">' . $diary['body']. '</div></div>'.$thumbnail.'</div>';
    return $output;
}