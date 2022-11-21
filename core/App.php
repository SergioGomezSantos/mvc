<?php

namespace Core;

// Use para los 2 controladores
use App\Controllers\AgendaController;
use App\Controllers\LoginController;

// Para el uso de sesiones
session_start();

class App
{
    function __construct()
    {
        // Compruebo si hay datos guardados en la Sesion que indican que ya se ha loggeado. Guardo si existen datos o no en $logged.
        (isset($_SESSION['userName']) && !empty($_SESSION['userName'])) ? $logged = true : $logged = false;

        // Compruebo si existe url en el GET. Si existe, la guardo en $url y si no existe, guardo "agenda".
        (isset($_GET["url"]) && !empty($_GET["url"])) ? $url = $_GET["url"] : $url = "agenda";

        // Trabajo con la url para separar el controlador de los argumentos.
        $arguments = explode('/', trim($url, '/'));
        $controllerName = array_shift($arguments);
        $controllerName = ucwords($controllerName) . 'Controller';

        // Si hay argumentos, quito el primero y lo guardo en $method. Si no hay argumento, guardo "index".
        count($arguments) ? $method = array_shift($arguments) : $method = "index";

        // Si ya está logged o va al controlador de Login, puede entrar en el bucle.
        if ($logged || $controllerName === "LoginController") {

            // Guardo la ruta del archivo del controller
            $file = "../app/controllers/$controllerName" . ".php";

            // Si el archivo existe, require
            if (file_exists($file)) {

                require_once "$file";

              // Si no existe, error
            } else {

                http_response_code(404);
                die("Not Found");
            }

            // Switch para filtrar que el controller existe para crear una instancia o muestra el error si no es ninguno válido
            switch ($controllerName) {

                case "AgendaController":
                    $controllerObject = new AgendaController;
                    break;

                case "LoginController":
                    $controllerObject = new LoginController;
                    break;

                default:
                    http_response_code(404);
                    die("Controller Not Found");
                    break;
            }

            // Si el método existe para el controller, lo ejecuta enviando los argumentos si tiene
            if (method_exists($controllerObject, $method)) {

                $controllerObject->$method($arguments);

              // Si no existe, error
            } else {

                http_response_code(404);
                die("Method Not Found");
            }

            // Si no ha entrado al bucle, redirección a /login.
        } else {

            header("Location: /login");
            die();
        }
    }
}
