<?php

$config_pages = array(
    'home' => array(
        'stylesheets' => array( 'home' ),
        'header' => array(
            
        ),
        'helper' => false
    ),
    'diary' => array(
        'stylesheets' => array( 'diary', 'list' ),
        'header' => array(
            'left' => array(
                'menu'
            ),
            'title' => '心雜音',
            'right' => array(
                'generate',
                'add'
            )
        ),
        'helper' => true
    ),
    'essay-list-v1' => array(
        'stylesheets' => array( 'essay-list', 'list', 'calendar' ),
        'header' => array(
            'left' => array(
                'menu'
            ),
            'title' => '心雜音',
            'right' => array(
                // 'search',
            )
        ),
        'helper' => true
    ),
    'essay-list-v2' => array(
        'stylesheets' => array( 'essay-list-v2', 'list', 'calendar' ),
        'header' => array(
            'left' => array(
                'menu'
            ),
            'title' => '心雜音',
            'right' => array(
                // 'search',
            )
        ),
        'helper' => true
    ),
    'essay-detail-v1' => array(
        'stylesheets' => array( 'essay-detail', 'diary', 'list' ),
        'header' => array(
            'left' => array(
                'esc'
            ),
            'title' => '篇章',
            'right' => array(
                'more',
            )
        ),
        'helper' => false
    ),
    'essay-detail-v2' => array(
        'stylesheets' => array( 'essay-detail-v2', 'diary', 'list', 'KuMincho-R' ),
        'header' => array(
            'left' => array(
                'esc'
            ),
            'title' => '篇章',
            'right' => array(
                'more',
            )
        ),
        'helper' => false
    ),
    'add' => array(
        'stylesheets' => array( 'add', 'location-selector' ),
        'scripts' => array('https://cdn.jsdelivr.net/npm/p5@1.9.0/lib/p5.min.js'),
        'header' => array(
            'left' => array(
                'esc'
            ),
            'title' => '新增碎片',
            'right' => array(
                'next-step-text',
                'edit-text'
            )
        ),
        'helper' => false
    ),
    'refresh' => array(
        'stylesheets' => array( 'refresh'),
        'helper' => false
    )
);