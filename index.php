<?php
require_once __DIR__ . '/static/php/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$website_mode=$_ENV['WEBSITE_MODE'] ?? 'dev';

$request = $_SERVER['REQUEST_URI'];
$requestclean = strtok($request,"?");
$uri = explode('/', $requestclean);
if(count($uri) > 2 && empty(end($uri))) array_pop($uri);

require_once __DIR__ . '/views/main.php';
?>
