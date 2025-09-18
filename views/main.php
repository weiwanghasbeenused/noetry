<?php
    require_once __DIR__ . '/../open-records-generator/config/config.php';
    require_once __DIR__ . '/../static/php/functions.php';
    require_once __DIR__ . '/../static/php/config-pages.php';
    $db = db_connect('guest');
    $config_page = array();
    function getPageConfig($uri){
        global $config_pages;
        $output = '';
        if(!$uri[1]) {
            $config_temp = $config_pages['home'] ?? array(); 
        } else {
            $config_temp = $config_pages;
            foreach($uri as $b) {
                if(!$b) continue;
                if(!isset($config_temp[$b])) break;
                $config_temp = $config_temp[$b];
            }
            
        }
        $output = $config_temp['page-data'] ?? array();
        return $output;
    }
    if(!$uri[1]) {
        $branch = array('home');        
    } else {
        $branch = $uri;
        array_shift($branch);
    }
    
    $page_config = getPageConfig($uri);
    $stylesheets = $page_config ? $page_config['stylesheets'] : array();
    $scripts = $page_config ? $page_config['scripts'] : array();
    $item = getItemByBranch($db, $branch);
    $site_title="Noetry Demo";
    $page_title=$item ? $item['name1'] . ' | ' . $site_title : $site_title;
    $attrs = array();
    foreach($_GET as $key => $value) {
        $attrs['data-'.$key] = $value;
    }
    $attrs_str = arrayToAttr($attrs);
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $page_title; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="manifest" href="manifest.json" />
        <link rel="stylesheet" href="/static/css/main.css">
        <?php foreach($stylesheets as $s) {
            ?><link rel="stylesheet" href="/static/css/<?php echo $s; ?>.css" /><?php 
        } ?>
        <?php foreach($scripts as $s) {
            if(strpos($s, 'http') === false) {
                $src = '/static/js/' . $s . '.js';
            } else {
                $src = $s;
            }
            ?><script src="<?php echo $src; ?>"></script><?php 
        } ?>
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    </head>
    <body>
        <div id="app" <?php echo $attrs_str; ?> data-stage="0">
        <?php 
            require_once(__DIR__ . '/main-header.php');
            if(!$uri[1]) require_once(__DIR__ . '/home.php');
            else if(file_exists(__DIR__ . '/'.$uri[1].'.php')){
                require_once(__DIR__ . '/'.$uri[1].'.php');
            } else echo '<br><br><br><br><br><br><div style="text-align:center">no view assigned</div>';
            require_once(__DIR__ . '/nav.php');
        ?>
        </div>
    </body>
</html>