<?php

$config_pages = array(
    'home' => array(
        'stylesheets' => array( 'home' ),
        'header' => array(
            
        )
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
        )
    ),
    'essay-list' => array(
        'stylesheets' => array( 'essay-list', 'list' ),
        'header' => array(
            'left' => array(
                'menu'
            ),
            'title' => '心雜音',
            'right' => array(
                'search',
            )
        )
    ),
    'essay-detail' => array(
        'stylesheets' => array( 'essay-detail', 'diary', 'list' ),
        'header' => array(
            'left' => array(
                'esc'
            ),
            'title' => '篇章',
            'right' => array(
                'more',
            )
        )
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
        )
    )
);