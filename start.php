<?php

require "../Controller.php";
$controller = new Controller();

if (isset($_GET["method"])) {

    $method = strtolower($_GET["method"]);

} else {

    $method = "home";
}

if (method_exists($controller, $method)) {

    $controller->$method();

} else {
    http_response_code(404);
    die("Method Not Found");
}
