<?php
include_once(__DIR__ . '/loading.php');
function renderLocarionSelector() {
    require_once __DIR__.'/header.php';
    $options = array(
        array(
            'display' => '大安站星巴克',
            'distance' => '200 m'
        ),
        array(
            'display' => '大安站星巴克',
            'distance' => '200 m'
        ),
        array(
            'display' => '大安站星巴克',
            'distance' => '200 m'
        ),
        array(
            'display' => '大安站星巴克',
            'distance' => '200 m'
        ),
        array(
            'display' => '大安站星巴克',
            'distance' => '200 m'
        ),
        array(
            'display' => '大安站星巴克',
            'distance' => '200 m'
        )
    );
    $header = renderHeader(array(
        'left' => array(
            'locator'
        ),
        'title' => '地點',
        'right' => array(
            'cancel-text'
        )
    ), '', array('sticky', 'location-selection-header'));
    $body = '';
    foreach($options as $option) {
        $body .= '<div class="location-option">
            <div class="location-option-display">'.$option['display'].'</div>
            <div class="location-option-distance small dark-grey">'.$option['distance'].'</div>
        </div>';
    }
    $body = '<div class="location-selection-body" ><div class="location-search tag border-less">搜尋</div><div class="options-container">' .$body. '</div></div>';
    $output = '<div class="location-selection full-vw fixed" data-hidden="1" data-fixed-align="bottom">'.$header.$body.'</div>';
    $output .= generateLoading('locating-loading', array('cancel'), '定位中...');
    return $output;
}

