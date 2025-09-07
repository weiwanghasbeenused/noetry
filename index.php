<?php
$request = $_SERVER['REQUEST_URI'];
$requestclean = strtok($request,"?");
$uri = explode('/', $requestclean);
if(count($uri) > 2 && empty(end($uri))) array_pop($uri);

require_once __DIR__ . '/views/main.php';
?>
