<?php

namespace App\Controllers;

class MainController extends Controller
{
    public function index(array $params)
    {
        var_dump($params);
        echo 'ok1';
    }
}