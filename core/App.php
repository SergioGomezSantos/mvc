<?php

namespace Core;

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\ProductController;

class App
{

    function __construct()
    {
        (isset($_GET["url"]) && !empty($_GET["url"])) ? $url = $_GET["url"] : $url = "home";

        $arguments = explode('/', trim($url, '/'));
        $controllerName = array_shift($arguments);
        $controllerName = ucwords($controllerName) . 'Controller';

        count($arguments) ? $method = array_shift($arguments) : $method = "index";

        $file = "../app/controllers/$controllerName" . ".php";

        if (file_exists($file)) {

            require_once "$file";
        } else {

            http_response_code(404);
            die("Not Found");
        }

        switch ($controllerName) {

            case "LoginController":
                $controllerObject = new LoginController;
                break;
            case "ProductController":
                $controllerObject = new ProductController;
                break;
            default:
                $controllerObject = new HomeController;
                break;
        }

        if (method_exists($controllerObject, $method)) {

            $controllerObject->$method($arguments);
        } else {

            http_response_code(404);
            die("Method Not Found");
        }
    }
}
