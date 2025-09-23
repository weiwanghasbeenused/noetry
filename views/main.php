<?php
    require_once __DIR__ . '/../open-records-generator/config/config.php';
    require_once __DIR__ . '/../static/php/functions.php';
    require_once __DIR__ . '/../config/config-pages.php';
    require_once __DIR__ . '/../static/php/getView.php';
    $db = db_connect('guest');
    $view = getView($uri);
    $page_config = $config_pages[$view] ?? array();
    
    if(!$uri[1]) {
        $branch = array('home');        
    } else {
        $branch = $uri;
        array_shift($branch);
    }
    
    $stylesheets = $page_config && isset($page_config['stylesheets'])? $page_config['stylesheets'] : array();
    $scripts = $page_config && isset($page_config['scripts'])? $page_config['scripts'] : array();
    $item = getItemByBranch($db, $branch);
    $site_title="Noetry Demo";
    $page_title=$item ? $item['name1'] . ' | ' . $site_title : $site_title;
    $attrs = array();
    foreach($_GET as $key => $value) {
        $attrs['data-'.$key] = $value;
    }
    $attrs['data-view'] = $view;
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
            
            if(!$uri[1]) require_once(__DIR__ . '/home.php');
            else {
                require_once(__DIR__ . '/main-header.php');
                if($view) require_once(__DIR__ . '/'.$view.'.php');
                else echo '<br><br><br><br><br><br><div style="text-align:center">no view assigned</div>';
                require_once(__DIR__ . '/nav.php');
            }
        ?>
        </div>
    </body>
</html>