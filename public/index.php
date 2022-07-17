<?php

define('ROOT', dirname(__DIR__));

use App\Autoloader;
use App\Core\Main;

require_once ROOT.'/autoloader.php';
Autoloader::register();

$app = new Main();

$app->start();