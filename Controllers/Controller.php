<?php

namespace App\Controllers;

abstract class Controller
{


    public function render(string $file, array $data = [], $template = 'default')
    {
        extract($data);

        ob_start();

        require_once ROOT.'/Views/'.$file.'.php';

        $content = ob_get_clean();

        require_once ROOT.'/Views/'. $template .'.php';
    }

}