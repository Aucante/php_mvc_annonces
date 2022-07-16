<?php

namespace App;

class Autoloader
{

    // Récupère classe grâce à la constante __CLASS__
    static function register()
    {
        spl_autoload_register([
            __CLASS__,
            'autoload'
        ]);
    }

    // Retire App du namespace et remplace / par \

    static function autoload($class){
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $class = str_replace('\\' , '/', $class);
        if (file_exists(__DIR__ . '/' . $class . '.php')){
            require __DIR__ . '/' . $class . '.php';
        }
    }
}