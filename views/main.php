<?php
    require_once __DIR__ . '/../open-records-generator/config/config.php';
    require_once __DIR__ . '/../static/php/functions.php';
    $db = db_connect('guest');
    if(!$uri[1]) {
        $branch = array('home');
    } else {
        $branch = $uri;
        array_shift($branch);
    }
    $item = getItemByBranch($db, $branch);
    $site_title="Noetry Demo";
    $page_title=$item ? $item['name1'] . ' | ' . $site_title : $site_title;
    $v = $_GET['v'] ?? 0; 
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $page_title; ?></title>
        <link rel="stylesheet" href="/static/css/main.css">
        <?php if($item) {
            ?><link rel="stylesheet" href="/static/css/<?php echo $item['url']; ?>.css"><?php 
        } ?>
        
    </head>
    <body>
        <div id="app" data-version="<?php echo $v; ?>">
        <?php 
            if(!$uri[1]) require_once(__DIR__ . '/home.php');
            else if($uri[1] === 'diary-list') require_once(__DIR__ . '/diary-list.php');
        ?>
        </div>
    </body>
</html>