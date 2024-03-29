<?php

namespace App\Core;

use App\Controllers\MainController;

/**
 * Main Router
 */
class Main
{
    public function start()
    {
        // Start session

        session_start();

        $uri = $_SERVER['REQUEST_URI'];

        if(!empty($uri) && $uri != '/' && $uri[-1] === '/'){
            $uri = substr($uri, 0, -1);

            http_response_code(301);

            header('Location: '.$uri);
            exit;
        }

        $params = explode('/', $_GET['p']);

        if($params[0] != ""){
            $controller = '\\App\\Controllers\\'.ucfirst(array_shift($params)).'Controller';

            $action = isset($params[0]) ? array_shift($params) : 'index';

            $controller = new $controller();

            if(method_exists($controller, $action)){
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            }else{
                http_response_code(404);
                echo "La page recherchée n'existe pas";
            }
        }else{
            $controller = new MainController();

            $controller->index();
        }

    }
}