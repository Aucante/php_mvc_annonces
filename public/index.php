<?php

define('ROOT', dirname(__DIR__));

use App\Autoloader;
use App\Models\AdsModel;

require_once ROOT.'/autoloader.php';
Autoloader::register();

$model = new AdsModel();

$ads = $model->findAll();

var_dump($ads);