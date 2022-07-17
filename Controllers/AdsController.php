<?php

namespace App\Controllers;

class AdsController extends Controller
{
    public function index()
    {
        $data = ['a', 'b'];
        include_once ROOT.'/Views/ads/index.php';
    }
}