<?php
session_start();

class App
{


    function __construct()
    {
        (isset($_SESSION['userName']) && !empty($_SESSION['userName'])) ? $logged = true : $logged = false;

        (isset($_GET["url"]) && !empty($_GET["url"])) ? $url = $_GET["url"] : $url = "agenda";

        $arguments = explode('/', trim($url, '/'));
        $controllerName = array_shift($arguments);
        $controllerName = ucwords($controllerName) . 'Controller';

        count($arguments) ? $method = array_shift($arguments) : $method = "index";

        if ($logged || $controllerName === "LoginController") {


            if ($logged && $controllerName === "LoginController" && $method !== "logout") {
                header("Location: /");
                die();
            }

            $file = "../app/controllers/$controllerName" . ".php";

            if (file_exists($file)) {

                require_once "$file";
            } else {

                http_response_code(404);
                die("Not Found");
            }

            $controllerObject = new $controllerName;

            if (method_exists($controllerObject, $method)) {

                $controllerObject->$method($arguments);
                
            } else {

                http_response_code(404);
                die("Method Not Found");
            }
            
        } else {

            header("Location: /login");
            die();
        }
    }
}
