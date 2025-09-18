<?php

$config_pages = array(
    'diary' => array(
        'page-data' => array(
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
    ),
    'poems' => array(
        'page-data' => array(
            'stylesheets' => array( 'poems', 'list' ),
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
        
    ),
    'add' => array(
        'page-data' => array(
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
        ),
        
    )
);