<?php 
require_once __DIR__.'/include/header.php';
$cls = array('full-vw', 'fixed');
$main_header_config = $page_config && isset($page_config['header']) ? $page_config['header'] : array(
    'left' => array(
        'menu'
    ),
    'title' => '心雜音',
    'right' => array(
        'generate',
        'add'
    )
);
echo renderHeader($main_header_config, 'main-header', $cls);
    
