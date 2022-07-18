<?php

namespace App\Controllers;

use App\Models\AdsModel;

class AdsController extends Controller
{
    public function index()
    {
        $adsModel = new AdsModel();

        $ads = $adsModel->findAll();

        $this->render('ads/index', compact('ads'));
    }

    /**
     * @param int $id $id Id de l'annonce
     * $return void
     */
    public function read(int $id)
    {
        $adsModel = new AdsModel();

        $ad = $adsModel->findById($id);

        $this->render('ads/read', compact('ad'));
    }
}